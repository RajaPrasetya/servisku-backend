<?php

namespace App\Http\Controllers;

use App\Models\FormService;
use App\Http\Requests\StoreFormServiceRequest;
use App\Http\Requests\UpdateFormServiceRequest;
use App\Http\Resources\FormServiceResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormServiceController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = FormService::with(['customer', 'user', 'detailService']);
            
            // Filter by status if provided
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter by customer if provided
            if ($request->has('id_customer')) {
                $query->where('id_customer', $request->id_customer);
            }
            
            // Filter by user/teknisi if provided
            if ($request->has('id_user')) {
                $query->where('id_user', $request->id_user);
            }
            
            // Search by customer name or user name
            if ($request->has('search')) {
                $search = $request->search;
                $query->whereHas('customer', function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                })->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            }
            
            $perPage = $request->get('per_page', 10);
            $formServices = $query->latest()->paginate($perPage);
            
            return $this->paginatedResponse(
                $formServices, 
                'Form services retrieved successfully',
                FormServiceResource::class
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve form services: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormServiceRequest $request): JsonResponse
    {
        try {
            $formService = FormService::create($request->validated());
            
            // Load relationships
            $formService->load(['customer', 'user']);
            
            return $this->createdResponse(
                new FormServiceResource($formService), 
                'Form service created successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to create form service: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FormService $formService): JsonResponse
    {
        try {
            $formService->load(['customer', 'user', 'detailService']);
            
            return $this->successResponse(
                new FormServiceResource($formService), 
                'Form service retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve form service: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormServiceRequest $request, FormService $formService): JsonResponse
    {
        try {
            $formService->update($request->validated());
            
            // Load relationships
            $formService->load(['customer', 'user', 'detailService']);
            
            return $this->successResponse(
                new FormServiceResource($formService->fresh()), 
                'Form service updated successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update form service: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormService $formService): JsonResponse
    {
        try {
            $formService->delete();
            
            return $this->successResponse(null, 'Form service deleted successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to delete form service: ' . $e->getMessage());
        }
    }

    /**
     * Update status of form service
     */
    public function updateStatus(Request $request, FormService $formService): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:diterima,proses,selesai'
        ]);

        try {
            $formService->update(['status' => $request->status]);
            
            $formService->load(['customer', 'user', 'detailService']);
            
            return $this->successResponse(
                new FormServiceResource($formService), 
                'Form service status updated successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update form service status: ' . $e->getMessage());
        }
    }

    /**
     * Get form services by customer
     */
    public function getByCustomer(Request $request, $customerId): JsonResponse
    {
        try {
            $query = FormService::with(['customer', 'user', 'detailService'])
                ->where('id_customer', $customerId);
            
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            $perPage = $request->get('per_page', 10);
            $formServices = $query->latest()->paginate($perPage);
            
            return $this->paginatedResponse(
                $formServices, 
                'Customer form services retrieved successfully',
                FormServiceResource::class
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve customer form services: ' . $e->getMessage());
        }
    }

    /**
     * Get form services by user/teknisi
     */
    public function getByUser(Request $request, $userId): JsonResponse
    {
        try {
            $query = FormService::with(['customer', 'user', 'detailService'])
                ->where('id_user', $userId);
            
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            $perPage = $request->get('per_page', 10);
            $formServices = $query->latest()->paginate($perPage);
            
            return $this->paginatedResponse(
                $formServices, 
                'User form services retrieved successfully',
                FormServiceResource::class
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve user form services: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics of form services
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => FormService::count(),
                'diterima' => FormService::where('status', 'diterima')->count(),
                'proses' => FormService::where('status', 'proses')->count(),
                'selesai' => FormService::where('status', 'selesai')->count(),
                'today' => FormService::whereDate('created_at', today())->count(),
                'this_month' => FormService::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count(),
            ];
            
            return $this->successResponse($stats, 'Form service statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve form service statistics: ' . $e->getMessage());
        }
    }
}
