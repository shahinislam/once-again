<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\Events\NewCustomerHasRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');//->except(['index']);
    }

    public function index()
    {
        $customers = Customer::with('company')->paginate(15);

        return view('customers.index', compact('customers'));


        //$activeCustomers = Customer::where('active', 1)->get();
        //$inactiveCustomers = Customer::where('active', 0)->get();

        /*return view('internals.customer',[
            'activeCustomers' => $activeCustomers,
            'inactiveCustomers' => $inactiveCustomers
        ]);*/

        /*$activeCustomers = Customer::active()->get();
        $inactiveCustomers = Customer::inactive()->get();*/

        /*return view('customers.index',
            compact('activeCustomers', 'inactiveCustomers'));*/

    }

    public function create()
    {
        $companies = Company::all();
        $customer = new Customer();
        return view('customers.create', compact('companies', 'customer'));
    }

    public function store(){

        /*$customer = new Customer();
        $customer->name = request('name');
        $customer->email = request('email');
        $customer->active = request('active');
        $customer->save();*/

        $this->authorize('create', Customer::class);

        $customer = Customer::create($this->validateRequest());// Mass assignment

        $this->storeImage($customer);

        event(new NewCustomerHasRegisteredEvent($customer));

        return redirect('customers');
    }

    public function show(Customer $customer)
    {
        //$customer = Customer::find($customer);
        //$customer = Customer::where('id', $customer)->firstOrFail();

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $companies = Company::all();
        return view('customers.edit', compact('customer', 'companies'));
    }

    public function update(Customer $customer)
    {
        $customer->update($this->validateRequest());

        $this->storeImage($customer);

        return redirect('/customers/' . $customer->id);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        $customer->delete();
        return redirect('customers');
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'active' => 'required',
            'company_id' => 'required',
            'image' => 'sometimes|required|image',
        ]);
    }

    private function storeImage($customer)
    {
        if(request()->has('image')){
            $customer->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);

            $image = Image::make(public_path('storage/' . $customer->image))->fit(300, 300);
            //->fit(300, 300, null, 'top-left');
            //->crop(300, 7000);
            $image->save();
        }
    }
}
