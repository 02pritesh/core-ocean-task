<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Video;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $videoCount = Video::count();
        $teacherCount = Teacher::count();

        return view('admin.dashboard', compact('videoCount', 'teacherCount'));
    }
}
