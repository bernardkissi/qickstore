<?php

namespace App\Services;

use App\Domains\User\User;
use App\Domains\User\Visitor;
use Illuminate\Http\Request;

trait DetectCustomer
{
    /**
     * Returns a user or a visitor
     *
     * @param [type] $customer
     * @return void
     */
    public function detect(Request $request): User|Visitor
    {
        $visitor = $request->visitor;
        return $request->has('visitor') && $visitor instanceof Visitor ? $visitor : auth()->user();
    }
}
