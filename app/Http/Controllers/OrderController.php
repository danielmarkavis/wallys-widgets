<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetRequest;
use App\Models\Widget;
use App\Repositories\WidgetRepository;
use Inertia\Response;
use Inertia\ResponseFactory;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WidgetRepository $repository): Response|ResponseFactory
    {
        $widgets = $repository->getQuery()->get();
        return inertia('Widgets/Index', compact('widgets'));
    }
}
