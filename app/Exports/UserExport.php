<?php

namespace App\Exports;

use App\User;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UserExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection,WithHeadings,WithCustomValueBinder,WithStyles, WithColumnWidths
{
    private $date, $category, $department;

    public function __construct($date, $category, $department) {
        $this->date = $date;
        $this->category = $category;
        $this->department = $department;
    }
    public function collection()
    {
        $date = $this->date;
        
        $users = User::select("id","first_name","last_name","phone")->with(['covid_form_submission' => function ($query) use($date){
            $query->whereDate('created_at', $date);
        }]);

        if(in_array($this->category,['agency','vinyl-pro','vinyl-pro office'])){
            $users = $users->where('affiliated_to',$this->category);
        }
        
        if(Department::where('id',$this->department)->exists()){
            $users = $users->where('department_id',$this->department);
        }
        
        $users = $users->get()->map(function($user){

            $user->first_name .= " " . $user->last_name;
            unset($user->id);
            unset($user->last_name);
            if(empty($user->phone)){
                $user->phone = " - ";
            }
            if($user->covid_form_submission){
                $user->time = $user->covid_form_submission->created_at;
                $user->status = " COMPLETED ";
                $user->q1 = strtoupper($user->covid_form_submission->fever);
                $user->q2 = strtoupper($user->covid_form_submission->cough);
                $user->q3 = strtoupper($user->covid_form_submission->shortness_of_breath);
                $user->q4 = strtoupper($user->covid_form_submission->trouble_in_swallowing);
                $user->q5 = strtoupper($user->covid_form_submission->stuffy_nose);
                $user->q6 = strtoupper($user->covid_form_submission->loss_of_taste);
                $user->q7 = strtoupper($user->covid_form_submission->nausea_etc);
                $user->q8 = strtoupper($user->covid_form_submission->tiredness);
                $user->q9 = strtoupper($user->covid_form_submission->ppe);
                $user->q10 = strtoupper($user->covid_form_submission->travelled_outside	);
            }else{
                $user->time = " - ";
                $user->status = " NOT ";
                $user->q1 = " - ";
                $user->q2 = " - ";
                $user->q3 = " - ";
                $user->q4 = " - ";
                $user->q5 = " - ";
                $user->q6 = " - ";
                $user->q7 = " - ";
                $user->q8 = " - ";
                $user->q9 = " - ";
                $user->q10 = " - ";
            }
            return $user;

        });

        return $users;
    }

    public function headings(): array
    {
        return ["Name", "Phone", "Time", "Status", "Q1", "Q2", "Q3", "Q4", "Q5", "Q6", "Q7", "Q8", "Q9", "Q10"];
    }

    public function columnWidths(): array
    {
        return [
            'A'     =>  25,
            'B'     =>  25,
            'C'     =>  25,
            'D'     =>  15,
            'E'     =>  10,
            'F'     =>  10,
            'G'     =>  10,
            'H'     =>  10,
            'I'     =>  10,
            'J'     =>  10,
            'K'     =>  10,
            'L'     =>  10,
            'M'     =>  10,
            'N'     =>  10,           
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
