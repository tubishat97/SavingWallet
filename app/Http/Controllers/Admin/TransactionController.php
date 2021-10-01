<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\Admin\AddTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user();

        $transactions = $user->transactions;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Transactions"],
        ];

        $addNewBtn = "admin.transaction.create";

        $pageConfigs = ['pageHeader' => true];

        return view('backend.transactions.list', compact('transactions', 'breadcrumbs', 'addNewBtn', 'pageConfigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Transactions"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $types = TransactionType::asSelectArray();

        $categories = $user->categoriesList();

        return view('backend.transactions.add', compact('breadcrumbs', 'pageConfigs', 'categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTransactionRequest $request)
    {
        try {
            $user = auth()->user();

            if ((int)$request->type == TransactionType::Expenses && !$this->canAddExpensesTransaction($user->wallet, $request->amount)) {
                return redirect()->back()->with('error', 'you dont have enough balance');
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->category_id = $request->category_id;
            $transaction->type = (int) $request->type;
            $transaction->amount = $request->amount;
            $transaction->note = $request->note;
            $transaction->save();

            $this->updateWallet($transaction);

            return redirect(route('admin.transaction.index'))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }


    private function canAddExpensesTransaction($wallet, $amount)
    {
        return $wallet->amount >= $amount;
    }

    private function updateWallet($transaction)
    {
        $user = $transaction->user;

        $wallet = $user->wallet;

        if ($transaction->type == TransactionType::Income) {
            $wallet->amount = $wallet->amount + $transaction->amount;
        } else {
            $wallet->amount = $wallet->amount - $transaction->amount;
        }

        $wallet->save();
    }
}
