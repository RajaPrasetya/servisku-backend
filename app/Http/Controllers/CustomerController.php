<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $customers = Customer::paginate(10);
            
            return $this->paginatedResponse($customers, 'Customers retrieved successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve customers');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {
            $customer = Customer::create($request->validated());
            
            return $this->createdResponse($customer, 'Customer created successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to create customer');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): JsonResponse
    {
        try {
            return $this->successResponse($customer, 'Customer retrieved successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve customer');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        try {
            $customer->update($request->validated());
            
            return $this->successResponse($customer->fresh(), 'Customer updated successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update customer');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        try {
            $customer->delete();
            
            return $this->successResponse(null, 'Customer deleted successfully');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to delete customer');
        }
    }
}
