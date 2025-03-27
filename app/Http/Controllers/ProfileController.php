<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function view(Request $request): View
    {
        $user = $request->user();
        $customer = $user->customer;
        $shippingAddress = $customer->shippingAddress ?: new CustomerAddress(['type'=> AddressType::Shipping]);
        $billingAddress = $customer->billingAddress ?: new CustomerAddress(['type'=>AddressType::Billing]);
        $countries = Country::query()->orderBy('name')->get();
        $countries = Country::query()->orderBy('name')->get();
        return view('profile.view', compact('customer', 'user', 'shippingAddress','billingAddress','countries'));
    }

    public function store(ProfileRequest $request)
    {
$customerData = $request->validated();
$shippingData = $customerData['shipping'];
$billingData = $customerData['billing'];
$user = $request->user();
$customer = $user->customer;
$customer ->update($customerData);
if($customer->shippingAddress){
    $customer->shippingAddress->update($shippingData);
} else {
    $shippingData['customer_id']=$customer->user_id;
    $shippingData['type'] = AddressType::Shipping->value;
    CustomerAddress::create($shippingData);
}
if ($customer->billingAddress){
    $customer->billingAddress->update($billingData);

}else {
    $billingData['customer_id']=$customer->user_id;
    $billingData['type'] = AddressType::Billing->value;
    CustomerAddress::create($billingData);
}

$request->session()->flash('flash_message','Profile was successfully updated');

return redirect()->route('profile');
    }


    public function passwordUpdate(PasswordUpdateRequest $request)

    {
        $user = $request->user();

        $passwordData = $request->validated();
        $user->password = Hash::make($passwordData['new_password']);
        $user->save();

        $request->session()->flash('flash_message', 'Your password is updated');

        return redirect()->route('profile');
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}