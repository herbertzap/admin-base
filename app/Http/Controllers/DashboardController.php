<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CustomsDeclaration;
use App\Models\Merchandise;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::where('is_active', true)->count(),
            'total_declarations' => CustomsDeclaration::count(),
            'pending_declarations' => CustomsDeclaration::where('status', 'draft')->count(),
            'submitted_declarations' => CustomsDeclaration::where('status', 'submitted')->count(),
            'approved_declarations' => CustomsDeclaration::where('status', 'approved')->count(),
            'total_merchandise' => Merchandise::count(),
        ];

        $recent_declarations = CustomsDeclaration::with(['company', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_declarations'));
    }
}
