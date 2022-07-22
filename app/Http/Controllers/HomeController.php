<?php

namespace App\Http\Controllers;

use App\Events\UnloadRequested;
use App\Models\Capacity;
use App\Models\InvoiceDate;
use App\Models\Stock;
use App\Models\StockUpload;
use App\Models\WindowShipping;
use App\Models\WorkOrder;
use App\Rules\ItemNumberCheck;
use App\Rules\ItemNumberValid;
use App\Rules\RackNumber;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('index')->with([
            'menu' => 'home',
        ]);
    }

    public function completeOrders() {
        if ($order_date = getSetting('orderdate')) {
            $stocks = Stock::where('updated_at', '>=', "{$order_date} 00:00:00")->pluck('item_number');
        } else {
            $stocks = Stock::pluck('item_number');
        }
        $invoice_dates = [];
        $dates = InvoiceDate::selectRaw('`ORDER NUMBER` as `order`, `ORIGINAL ORDER#` as `original`')->get();
        foreach ($dates as $date) {
            if ($date['order']) $invoice_dates[] = $date['order'];
            if ($date['original']) $invoice_dates[] = $date['original'];
        }
        $items = [];
        foreach ($stocks as $stock) {
            $order = explode('-', $stock)[0];
            if (in_array($order, $invoice_dates)) continue;
            if (empty($items[$order])) $items[$order] = 0;
            $items[$order]++;
        }
        $companies = WorkOrder::whereIn('ORDER #', array_keys($items))
            ->groupBy('ORDER #')
            ->selectRaw('`id`, `ORDER #` as `order`, `DEALER`')
            ->get();
        $orders = [];
        $total = 0;
        foreach ($companies as $company) {
            if (empty($orders[$company['DEALER']])) {
                $orders[$company['DEALER']] = ['id' => $company['id'], 'number' => 0];
            }
            $orders[$company['DEALER']]['number'] += ($n = empty($items[$company['order']]) ? 0 : $items[$company['order']]);
            $total += $n;
        }
        return view('complete-orders')->with([
            'menu' => 'completeorders',
            'orders' => $orders,
            'total' => $total,
        ]);
    }

    public function getOrderDetail($id) {
        $company = WorkOrder::find($id);
        if (!$company) return back()->with('error_message', 'Company does not exist.');
        if ($order_date = getSetting('orderdate')) {
            $stocks = Stock::where('updated_at', '>=', "{$order_date} 00:00:00")->get(['item_number', 'updated_at']);
        } else {
            $stocks = Stock::get(['item_number', 'updated_at']);
        }
        $invoice_dates = [];
        $dates = InvoiceDate::selectRaw('`ORDER NUMBER` as `order`, `ORIGINAL ORDER#` as `original`')->get();
        foreach ($dates as $date) {
            if ($date['order']) $invoice_dates[] = $date['order'];
            if ($date['original']) $invoice_dates[] = $date['original'];
        }
        $items = [];
        foreach ($stocks as $stock) {
            $order = explode('-', $stock['item_number'])[0];
            if (in_array($order, $invoice_dates)) continue;
            if (empty($items[$order])) {
                $items[$order] = [
                    'number' => 0,
                    'date' => null,
                ];
            }
            $date = explode(' ', $stock['updated_at'])[0];
            $items[$order]['number']++;
            if (!$items[$order]['date'] || $items[$order]['date'] < $date) {
                $items[$order]['date'] = $date;
            }
        }
        $orders = WorkOrder::whereIn('ORDER #', array_keys($items))
            ->where('DEALER', $company['DEALER'])
            ->groupBy('ORDER #')
            ->selectRaw('`ORDER #` as `order`, `DEALER`, `PO`, `ORDER DATE`, `DUE DATE`, count(`id`) as `number`, `id` as `days`')
            ->get();
        $today = date('Y-m-d');
        $total = 0;
        foreach ($orders as $order) {
            if (empty($items[$order['order']])) {
                $order['number'] = $order['days'] = 0;
            } else {
                $total += ($order['number'] = $items[$order['order']]['number']);
                $order['days'] = abs(round((strtotime($items[$order['order']]['date']) - strtotime($today)) / (60 * 60 * 24)));
            }
        }
        return view('order-detail')->with([
            'menu' => 'completeorders',
            'company' => $company,
            'orders' => $orders,
            'total' => $total,
        ]);
    }

    public function searchWindow()
    {
        return view('search-window')->with([
            'menu' => 'search',
        ]);
    }

    public function postSearchWindow(Request $request)
    {
        $item_number = $request['item_number'];
        $total_available = WorkOrder::where('LINE #1', 'like', $item_number . '-%')->sum('qty');
        $stocks = Stock::where('item_number', $item_number)
            ->orWhere('item_number', 'like', $item_number . '-%')
            ->groupBy('rack_number')
            ->select(['*', DB::raw('COUNT(rack_number) as qty')])
            ->get();
        foreach ($stocks as $stock) {
            $stock['aisle'] = substr($stock['rack_number'], 0, 1);
            $stock['rack_number'] = substr($stock['rack_number'], 1);
        }
        return response([
            'stocks' => $stocks,
            'total_available' => $total_available,
        ]);
    }

    public function searchOrder()
    {
        return view('order-search')->with([
            'menu' => 'order_search',
        ]);
    }

    public function postSearchOrder(Request $request)
    {
        $order_number = $request['order_number'];
        $orders = WorkOrder::where('ORDER #', '=', $order_number)->get();
        foreach ($orders as $row){
            $row['location'] = 'No';
            $stock = Stock::where('item_number', '=', $row['LINE #1'])->first();
            if ($stock !== null) {
                $row['location'] = $stock['rack_number'];
                $row['created_at'] = $stock['created_at'];
                $row['wrapper'] = $stock['name'];
                $row['note'] = $stock['note'];
            }
            // $row['shipped'] = 'No';
            $windowshipping = WindowShipping::where('Line_number', '=', $row['LINE #1'])->first();
            if ($windowshipping !== null) {
                $row['shipped'] = 'YES';
            }
        }

        $match=[];
        if( count($orders) > 0){
            $match = $orders[0];
            foreach ($orders as $row){
                if($row['note']!==null){
                    $match['note']=$row['note'];
                    break;
                }
            }
        }
       
        return response([
            'orders' => $orders,
            'match' => $match,
        ]);
    }

    public function postUploadRequest(Request $request)
    {
        $rule = [
            'item_number' => 'required',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Please upload the result after search window');
        }
        $item_number = $request['item_number'];
        $stocks = Stock::where('item_number', $item_number)
            ->orWhere('item_number', 'like', $item_number . '-%')
            ->groupBy('rack_number')
            ->select(['*', DB::raw('COUNT(rack_number) as qty')])
            ->get();
        foreach ($stocks as $stock) {
            if (strcasecmp(substr($stock['rack_number'], 1, 1), 'G') == 0) {
                continue;
            }
            StockUpload::updateOrCreate([
                'rack_number' => $stock['rack_number'],
                'deleted' => 0,
            ], [
                'qty' => $stock['qty'],
            ]);
        }
        event(new UnloadRequested('Please unload buggy in list.'));
        return back()->with('info_message', 'Message sent successfully !');
    }

    public function stockWindow()
    {
        return view('stock-window')->with([
            'menu' => 'stock',
        ]);
    }

    public function getWindowRelocate()
    {
        return view('window-relocate')->with([
            'menu' => 'relocate',
        ]);
    }

    public function postWindowRelocate(Request $request)
    {
        $user = Auth::user();
        $rule = [
            'rack_number' => ['required', new RackNumber],
            'item_number' => ['required', new ItemNumberCheck($request['rack_number'])],
            'capacity' => 'required|in:0,25,50,75,100',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
        }
        $request['rack_number'] = strtoupper($request['rack_number']);
        $item_numbers = explode("\r\n", str_replace(' ', '', $request['item_number']));
        $aisle = substr($request['rack_number'], 0, 1);
        $rack_letter = substr($request['rack_number'], 1, 1);
        $rack_number = (int)substr($request['rack_number'], 2);
        if (strcasecmp($rack_letter, 'A') == 0 || strcasecmp($rack_letter, 'B') == 0) {
            $max = getSetting('rack_' . strtolower($rack_letter) . '_max');
            $rule['weight'] = ['required', 'numeric'];
            $weight = $request['weight'];
            if ($max > 0) {
                $min_rack = ($rack_number % 2 == 1) ? ($rack_number - 25) : $rack_number;
                $max_rack = ($rack_number % 2 == 1) ? $rack_number : ($rack_number + 25);
                $total_weight = Stock::where('rack_number', $aisle . $rack_letter . $min_rack)
                        ->orWhere('rack_number', $aisle . $rack_letter . $max_rack)
                        ->sum('weight')
                    + $weight * count($item_numbers);
                $request['weight'] = $total_weight;
                $rule['weight'] = ['required', 'numeric', 'max:' . $max];
            }
            $messages = [
                'max' => 'The Rack ' . $aisle . $rack_letter . $rack_number . ' :attribute may not be greater than ' . $max . '.',
            ];
            $validator = Validator::make($request->all(), $rule, $messages);
            $request['weight'] = $weight;
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
            }
        }
        foreach ($item_numbers as $item_number) {
            $stock = Stock::where('item_number', $item_number)
                ->where('rack_number', '!=', $request->rack_number)
                ->first();
            if ($stock) {
                if (strcasecmp($rack_letter, 'G') != 0) {
                    $stock['weight'] = $request['weight'];
                }
                $stock['rack_number'] = $request['rack_number'];
                $stock['name'] = $user->first_name . " " . $user->last_name . " ( " . $user->username . " )";
                $stock['note'] = $request['note'];
                $stock->save();
            }
            Capacity::updateOrCreate(
                ["rack_number" => $request['rack_number']],
                ["capacity" => $request->capacity]
            );
        }
        return back()->with('info_message', 'Successfully saved');
    }

    public function postStockWindow(Request $request)
    {
        $user = Auth::user();
        $rule = [
            'rack_number' => ['required', new RackNumber],
            'item_number' => ['required', new ItemNumberValid],
            'capacity' => 'required|in:0,25,50,75,100',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
        }
        $request['rack_number'] = strtoupper($request['rack_number']);
        $item_numbers = explode("\r\n", str_replace(' ', '', $request['item_number']));
        $aisle = substr($request['rack_number'], 0, 1);
        $rack_letter = substr($request['rack_number'], 1, 1);
        $rack_number = (int)substr($request['rack_number'], 2);
        if (strcasecmp($rack_letter, 'A') == 0 || strcasecmp($rack_letter, 'B') == 0) {
            $max = getSetting('rack_' . strtolower($rack_letter) . '_max');
            $rule['weight'] = ['required', 'numeric'];
            $weight = $request['weight'];
            if ($max > 0) {
                $min_rack = ($rack_number % 2 == 1) ? ($rack_number - 25) : $rack_number;
                $max_rack = ($rack_number % 2 == 1) ? $rack_number : ($rack_number + 25);
                $total_weight = Stock::where('rack_number', $aisle . $rack_letter . $min_rack)
                        ->orWhere('rack_number', $aisle . $rack_letter . $max_rack)
                        ->sum('weight')
                    + $weight * count($item_numbers);
                $request['weight'] = $total_weight;
                $rule['weight'] = ['required', 'numeric', 'max:' . $max];
            }
            $messages = [
                'max' => 'The Rack ' . $aisle . $rack_letter . $rack_number . ' :attribute may not be greater than ' . $max . '.',
            ];
            $validator = Validator::make($request->all(), $rule, $messages);
            $request['weight'] = $weight;
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
            }
        }
        foreach ($item_numbers as $item_number) {
            $stock = new Stock();
            $stock['rack_number'] = $request['rack_number'];
            if (strcasecmp($rack_letter, 'G') != 0) {
                $stock['weight'] = $request['weight'];
            }

            $stock['item_number'] = $item_number;
            $stock['name'] = $user->first_name . " " . $user->last_name . " ( " . $user->username . " )";
            $stock['note'] = $request['note'];
            $stock->save();
            Capacity::updateOrCreate(
                ["rack_number" => $request->rack_number],
                ["capacity" => $request->capacity]
            );
        }
        return back()->with('info_message', 'Successfully saved');
    }

    public function getCurrentWeight(Request $request)
    {
        $stock = Stock::find($request['stock_id']);
        $rule = [
            'rack_number' => ['required', new RackNumber],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response([
                'status' => 201,
                'message' => 'invalid rack number',
            ]);
        }
        $aisle = substr($request['rack_number'], 0, 1);
        $rack_letter = substr($request['rack_number'], 1, 1);
        $rack_number = (int)substr($request['rack_number'], 2);
        if (strcasecmp($rack_letter, 'A') == 0 || strcasecmp($rack_letter, 'B') == 0) {
            $max = getSetting('rack_' . strtolower($rack_letter) . '_max');
            if ($max > 0) {
                $min_rack = ($rack_number % 2 == 1) ? ($rack_number - 25) : $rack_number;
                $max_rack = ($rack_number % 2 == 1) ? $rack_number : ($rack_number + 25);
                $total_weight = Stock::where('rack_number', $aisle . $rack_letter . $min_rack)
                    ->orWhere('rack_number', $aisle . $rack_letter . $max_rack)
                    ->sum('weight');
                $data = Stock::where('stocks.rack_number', $aisle . $rack_letter . $min_rack)
                    ->orWhere('stocks.rack_number', $aisle . $rack_letter . $max_rack)
                    ->leftJoin('capacities', function ($join) {
                        $join->on('capacities.rack_number', '=', 'stocks.rack_number');
                    })
                    ->select('note', 'capacities.capacity')
                    ->orderBy('stocks.created_at', 'desc')
                    ->first();
                if (!empty($stock) && strcasecmp($rack_letter, substr($stock['rack_number'], 1, 1)) == 0) {
                    $total_weight -= $stock['weight'];
                }
                return response([
                    'status' => 200,
                    'message' => 'available weight ' . ($max - $total_weight),
                    "data" => $data,
                ]);
            }
            return response([
                'status' => 202,
                'message' => 'did not set max value for rack ' . $rack_letter . ' yet.',
            ]);
        }
        return response([
            'status' => 203,
            'message' => 'not available weight',
        ]);
    }

    public function editRecords()
    {
        return view('get-record')->with([
            'menu' => 'record',
        ]);
    }

    public function deleteRecords(Request $request)
    {
        $ids = $request['ids'];
        Stock::whereIn('id', $ids)->delete();
        return back()->with('info_message', 'Successfully deleted');
    }

    public function getRecords(Request $request)
    {
        $item_number = $request['item_number'];
        $stocks = Stock::where('item_number', 'like', $item_number . '%')->get();
        return response([
            'stocks' => $stocks,
        ]);
    }

    public function getRecord($id)
    {
        $stock = Stock::where('stocks.id', $id)
            ->select('stocks.id', 'stocks.rack_number', 'stocks.weight', 'stocks.item_number', 'stocks.name', 'stocks.note', 'stocks.created_at', 'stocks.updated_at', 'capacities.capacity')
            ->leftJoin('capacities', function ($join) {
                $join->on('capacities.rack_number', '=', 'stocks.rack_number');
            })->first();
        if (empty($stock)) {
            return back()->with('error_message', 'Cannot find data');
        }
        return view('edit-record')->with([
            'menu' => 'record',
            'stock' => $stock,
        ]);
    }

    public function postRecord($id, Request $request)
    {
        $user = Auth::user();
        $stock = Stock::find($id);
        if (empty($stock)) {
            return back()->with('error_message', 'Cannot find data');
        }
        $rule = [
            'rack_number' => ['required', new RackNumber],
            'item_number' => 'required',
            'capacity' => 'required|in:0,25,50,75,100',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
        }
        $request['rack_number'] = strtoupper($request['rack_number']);
        $aisle = substr($request['rack_number'], 0, 1);
        $rack_letter = substr($request['rack_number'], 1, 1);
        $rack_number = (int)substr($request['rack_number'], 2);
        if (strcasecmp($rack_letter, 'A') == 0 || strcasecmp($rack_letter, 'B') == 0) {
            $max = getSetting('rack_' . strtolower($rack_letter) . '_max');
            $rule['weight'] = ['required', 'numeric'];
            $weight = $request['weight'];
            if ($max > 0) {
                $min_rack = ($rack_number % 2 == 1) ? ($rack_number - 25) : $rack_number;
                $max_rack = ($rack_number % 2 == 1) ? $rack_number : ($rack_number + 25);
                $total_weight = Stock::where('rack_number', $aisle . $rack_letter . $min_rack)
                        ->orWhere('rack_number', 'like', $aisle . $rack_letter . $max_rack)
                        ->sum('weight')
                    + $weight;
                if (strcasecmp($rack_letter, substr($stock['rack_number'], 1, 1)) == 0) {
                    $total_weight -= $stock['weight'];
                }
                $request['weight'] = $total_weight;
                $rule['weight'] = ['required', 'numeric', 'max:' . $max];
            }
            $messages = [
                'max' => 'The Rack ' . $aisle . $rack_letter . $rack_number . ' :attribute may not be greater than ' . $max . '.',
            ];
            $validator = Validator::make($request->all(), $rule, $messages);
            $request['weight'] = $weight;
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
            }
        }
        $stock['rack_number'] = $request['rack_number'];
        if (strcasecmp($rack_letter, 'G') != 0) {
            $stock['weight'] = $request['weight'];
        }
        $stock['item_number'] = $request['item_number'];
        $stock['name'] = $user->first_name . " " . $user->last_name . " ( " . $user->username . " )";
        $stock['note'] = $request['note'];
        $stock->save();
        Capacity::updateOrCreate(
            ["rack_number" => $request->rack_number],
            ["capacity" => $request->capacity]
        );
        return back()->with('info_message', 'Successfully saved');
    }

    public function uploadRequest()
    {
        return view('upload-request')->with([
            'menu' => 'upload',
        ]);
    }

    public function getUploadRequest()
    {
        $uploads = StockUpload::where('deleted', 0)->get();
        foreach ($uploads as $upload) {
            $upload['aisle'] = substr($upload['rack_number'], 0, 1);
            $upload['rack_number'] = substr($upload['rack_number'], 1);
            $upload['date'] = date('Y-m-d', strtotime($upload['created_at']));
            $upload['time'] = date('h:i:s a', strtotime($upload['created_at']));
        }
        return response([
            'uploads' => $uploads,
        ]);
    }

    public function deleteUpload($id)
    {
        if ($id == 0) {
            StockUpload::where('deleted', 0)->update(['deleted' => 1]);
        } else {
            StockUpload::where('id', $id)->update(['deleted' => 1]);
        }
        return back();
    }

    public function getAllData()
    {
        $stocks = Stock::get();
        return view('all-data')->with([
            'menu' => 'database',
            'stocks' => $stocks,
        ]);
    }

    public function deleteShippedItems()
    {
        $item_numbers = WindowShipping::select("Line_number")->get()->pluck('Line_number')->toArray();
        Stock::whereIn('item_number', $item_numbers)
            ->update([
                "deleted_at" => now(),
            ]);
    }

    public function getRackInfo($aisle)
    {
        $this->deleteShippedItems();
        $rows = ["A", "B", "C", "G"];
        $aisle = strtoupper($aisle);
        $rackA = $rackB = $rackC = $rackG = [];
        if ($aisle == "G" || $aisle == "H") {
            $end = 425;
        } else if ($aisle == "I" || $aisle == "J") {
            $end = 675;
        } else if ($aisle == "K") {
            $end = 725;
        } else {
            $end = 575;
        }
        for ($i = 100; $i <= $end; $i += 25) {
            for ($j = 0; $j < 4; $j++) {
                $rack = Stock::where('stocks.rack_number', $aisle . $rows[$j] . $i)
                    ->select([DB::raw('SUM(weight) as weight'), DB::raw('COUNT(item_number) as qty'), DB::raw('GROUP_CONCAT(item_number) as item_number')])
                    ->addSelect('capacities.capacity')
                    ->leftJoin('capacities', function ($join) {
                        $join->on('capacities.rack_number', '=', 'stocks.rack_number');
                    })
                    ->groupBy('stocks.rack_number')
                    ->first();
                if (!empty($rack)) {
                    $item_number = [];
                    $items = explode(',', $rack['item_number']);
                    foreach ($items as $item) {
                        $temp = explode('-', $item)[0];
                        if (!in_array($temp, $item_number)) {
                            array_push($item_number, $temp);
                        }
                    }
                    $rack['item_number'] = $item_number;
                }
                if ($j == 0) {
                    $rackA[$i] = $rack;
                } else if ($j == 1) {
                    $rackB[$i] = $rack;
                } else if ($j == 2) {
                    $rackC[$i] = $rack;
                } else {
                    $rackG[$i] = $rack;
                }
            }
        }
        return view('rack-info')->with([
            'menu' => 'rack',
            'aisle' => $aisle,
            'rackA' => $rackA,
            'rackB' => $rackB,
            'rackC' => $rackC,
            'rackG' => $rackG,
            'end' => $end,
        ]);
    }

    public function settings()
    {
        $setting = getSetting();
        return view('settings')->with([
            'menu' => 'setting',
            'setting' => $setting,

        ]);
    }

    public function postSettings(Request $request)
    {
        $rule = [
            'rack_a_max' => ['required', 'numeric'],
            'rack_b_max' => ['required', 'numeric'],
            'orderdate' => ['required', 'date'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rule');
        }
        updateSetting($request->except(['_token']));
        return back()->with('info_message', 'Successfully saved');
    }
}
