<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetRequest;
use App\Models\Widget;
use App\Repositories\WidgetRepository;
use App\Services\WidgetServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WidgetRepository $repository): Response|ResponseFactory
    {
        $widgets = $repository->getQuery()->orderby('size', 'desc')->get();

        return inertia('Widgets/Index')->with(compact('widgets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWidgetRequest $request, WidgetServiceInterface $widgetService, WidgetRepository $repository): Response|ResponseFactory
    {
        $data = $request->validated();

        $quantity = $data['quantity'];
        $packs = collect($repository->getQuery()->orderby('size', 'desc')->get()->toArray())->pluck('size');

        $widgetService->setPacks($packs->toArray());

        $order = $widgetService->execute($quantity);

        $widgets = $repository->getQuery()->orderby('size', 'desc')->get();

        return inertia('Widgets/Index')->with(compact('order','widgets'));
    }
}
