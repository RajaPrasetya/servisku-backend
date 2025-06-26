<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Customer::query();
            
            // Search by name, phone, or address
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('no_telp', 'LIKE', "%{$search}%")
                      ->orWhere('alamat', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by specific fields
            if ($request->has('nama')) {
                $query->where('nama', 'LIKE', "%{$request->nama}%");
            }
            
            if ($request->has('no_telp')) {
                $query->where('no_telp', 'LIKE', "%{$request->no_telp}%");
            }
            
            // Include form services if requested
            if ($request->boolean('with_services')) {
                $query->with('formServices');
            }
            
            $perPage = $request->get('per_page', 10);
            $customers = $query->latest()->paginate($perPage);
            
            return $this->paginatedResponse(
                $customers,
                'Customers retrieved successfully',
                CustomerResource::class
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve customers: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {
            $customer = Customer::create($request->validated());
            
            return $this->createdResponse(
                new CustomerResource($customer), 
                'Customer created successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to create customer: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Request $request): JsonResponse
    {
        try {
            // Include form services if requested
            if ($request->boolean('with_services')) {
                $customer->load('formServices');
            }
            
            return $this->successResponse(
                new CustomerResource($customer), 
                'Customer retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve customer: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        try {
            $customer->update($request->validated());
            
            return $this->successResponse(
                new CustomerResource($customer->fresh()), 
                'Customer updated successfully'
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update customer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        try {
            // Check if customer has form services
            if ($customer->formServices()->exists()) {
                return $this->errorResponse(
                    'Cannot delete customer. Customer has existing form services.',
                    400
                );
            }
            
            $customer->delete();
            
            return $this->successResponse(null, 'Customer deleted successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to delete customer: ' . $e->getMessage());
        }
    }

    /**
     * Search customers by various criteria
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2',
            'fields' => 'sometimes|array',
            'fields.*' => 'in:nama,no_telp,alamat'
        ]);

        try {
            $query = Customer::query();
            $searchTerm = $request->q;
            $fields = $request->get('fields', ['nama', 'no_telp', 'alamat']);
            
            $query->where(function($q) use ($searchTerm, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$searchTerm}%");
                }
            });
            
            $perPage = $request->get('per_page', 10);
            $customers = $query->latest()->paginate($perPage);
            
            return $this->paginatedResponse(
                $customers,
                'Search results retrieved successfully',
                CustomerResource::class
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Search failed: ' . $e->getMessage());
        }
    }

    /**
     * Get customer statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_customers' => Customer::count(),
                'customers_today' => Customer::whereDate('created_at', today())->count(),
                'customers_this_month' => Customer::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count(),
                'customers_with_services' => Customer::has('formServices')->count(),
                'customers_without_services' => Customer::doesntHave('formServices')->count(),
            ];
            
            return $this->successResponse($stats, 'Customer statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve customer statistics: ' . $e->getMessage());
        }
    }
}
