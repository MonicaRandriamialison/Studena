<?php

namespace App\Http\Controllers;

use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        return Student::select('id', 'full_name', 'level')->orderBy('full_name')->get();
    }
}
