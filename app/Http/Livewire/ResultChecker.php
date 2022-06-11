<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Semester;
use App\Services\MyClass\MyClassService;
use App\Services\Section\SectionService;

class ResultChecker extends Component
{
    public $section, $sections, $classes, $class, $students, $student, $academicYears, $academicYear, $semesters, $semester, $exams, $examRecords, $subjects;

    //rules
    public $rules = [
        'academicYear' => 'integer|exists:academic_years,id',
        'semester' => 'required',
    ];

    public function mount(SectionService $sectionService, MyClassService $myClassService)
    {
        $this->academicYears = auth()->user()->school->academicYears;
        $this->academicYear = $this->academicYears->first()->id;
        $this->updatedAcademicYear();

        $this->classes = $myClassService->getAllClasses();

        if ($this->classes->isEmpty()) {
           return;
        }

        $this->class = $this->classes[0]->id;
        $this->updatedClass();
    }

    //updated academic year
    public function updatedAcademicYear()
    {
        $academicYear = app("App\Services\AcademicYear\AcademicYearService")->getAcademicYearById($this->academicYear);

        //get semesters in academic year
        $this->semesters = $academicYear->semesters;

        if ($this->semesters->isEmpty()) {
            return;
        }
        
        $this->semester = $this->semesters[0]->id;
    }

    public function updatedClass()
    {
        //get instance of class
        $class = app("App\Services\MyClass\MyClassService")->getClassById($this->class);

        //get sections in class
        $this->sections = $class->sections;

        //set section if the fetched records aren't empty
        if ($this->sections->isEmpty()) {
            $this->students = null;
            return;
        }
       $this->section = $this->sections[0]->id;
      
       $this->updatedSection();
        
    }

    public function updatedSection()
    {
        //get instance of section
        $section = app("App\Services\Section\SectionService")->getSectionById($this->section);

        //get students in section
        $this->students = $section->studentRecords->map(function ($studentRecord) {
            return $studentRecord->user;
        });
        
        //set student if the fetched records aren't empty
        $this->students->count() ? $this->student = $this->students[0]->id : $this->student = null;
    }

    function checkResult(Semester $semester, User $student)
    {
        // make sure user student isn't another role
        if (!$student->hasRole('student')) {
            abort(404, 'Student not found.');
        }
       
        // fetch all exams, subjects and exam records for user in semester
        $this->exams = $semester->exams;
        $this->subjects = $student->studentRecord->myClass->subjects;
        //fetch all students exam records in semester
        $this->examRecords = app("App\Services\Exam\ExamRecordService")->getAllUserExamRecordInSemester($semester, $student->id);
    }

    public function render()
    {
        return view('livewire.result-checker');
    }
}
