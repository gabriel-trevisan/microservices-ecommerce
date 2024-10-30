<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Retorna todas as informações dos clientes
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json($customers);
    }
    
    /**
     * Retorna as informações de um cliente pelo ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        return response()->json($customer);
    }

    /**
     * Cria um novo cliente.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($customer, 201);
    }
}
