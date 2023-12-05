<?php

namespace App\Http\Controllers\Transaction;

use App\Enums\BuyerStatus;
use App\Enums\SellerStatus;
use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    private $transaction;
    private $mail;

    public function __construct(
        Transactions $transaction,
        MailService $mail
        )
    {
        $this->transaction = $transaction;
        $this->mail = $mail;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->transaction
            ->with('car', 'user')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($data, 200);
    }

    public function historySaleCar()
    {
        $data = $this->transaction
            ->with([
                'car' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
                'user',
            ])
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function historyBuyCar()
    {
        $data = $this->transaction
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->with(['user', 'car'])
            ->get();

        return response()->json($data, 200);
    }

    public function HistoryTransactionBuyer()
    {
        $loggedInUserId = Auth::id();

        $data = $this->transaction->with(['car' => function ($query) {
            $query->with('user');
        }, 'user'])
            ->where('user_id', $loggedInUserId)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($data, 200);
    }
    public function HistoryTransactionSeller()
    {
        $loggedInUserId = Auth::id();
        $data = $this->transaction->with(['car' => function ($query) {
            $query->with('user');
        }, 'user'])
            ->whereHas('car', function ($query) use ($loggedInUserId) {
                $query->where('user_id', $loggedInUserId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($data, 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $param = $request->all();

        $user_id = Auth::id();

        $transaction = $this->transaction->create([
            'user_id' => $user_id,
            'car_id' => $param['car_id'],
            'transaction_date' => Carbon::now(),
            'status' => TransactionStatus::WaitSellerConfirm,
            'seller_status' => SellerStatus::Created,
            'buyer_status' => BuyerStatus::Created,
        ]);

        return $transaction;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = $this->transaction
            ->where('id', $id)
            ->first();

        $user_id = Auth::id();

        $is_buyer = ($transaction->user_id === $user_id) ? true : false;
        $is_seller = ($transaction->car->user_id === $user_id) ? true : false;

        if (!$transaction || (!$is_buyer || !$is_seller)) {
            return response()->json([
                'message' => 'transaction not found'
            ], 404);
        }

        return $transaction;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sellerConfirm(string $id)
    {
        $user_id = Auth::id();
        $transaction = $this->transaction->where('id', $id)
            ->whereHas('car', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->first();
        if (!$transaction) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $transaction->status = TransactionStatus::Trading;

        $transaction->save();

        $this->mail->sellerConfirm($transaction->user->email);

        return $transaction;
    }

    public function buyerApprove(string $id)
    {
        $user_id = Auth::id();

        $transaction = $this->transaction
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $transaction->buyer_status = BuyerStatus::Approved;

        if ($transaction->seller_status == SellerStatus::Approved) {
            $transaction->status = TransactionStatus::Done;
        }

        $transaction->save();

        $this->mail->buyerApprove($transaction->car->user->email);

        return $transaction;
    }

    public function buyerRefuse(string $id)
    {
        $user_id = Auth::id();

        $transaction = $this->transaction
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $transaction->buyer_status = BuyerStatus::Refused;

        $transaction->status = TransactionStatus::Cancelled;

        $transaction->save();

        $this->mail->buyerRefuse($transaction->car->user->email);

        return $transaction;
    }

    public function sellerApprove(string $id)
    {
        $user_id = Auth::id();

        $transaction = $this->transaction
            ->where('id', $id)
            ->with(['car' => function ($query) {
                $query->with('user');
            }, 'user'])
            ->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $transaction->seller_status = SellerStatus::Approved;

        if ($transaction->buyer_status == BuyerStatus::Approved) {
            $transaction->status = TransactionStatus::Done;
        }

        $transaction->save();

        $this->mail->sellerApprove($transaction->user->email);

        return $transaction;
    }

    public function sellerRefuse(string $id)
    {
        $user_id = Auth::id();

        $transaction = $this->transaction
            ->where('id', $id)
            ->with(['car' => function ($query) {
                $query->with('user');
            }, 'user'])
            ->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $transaction->seller_status = SellerStatus::Refused;

        $transaction->status = TransactionStatus::Cancelled;

        $transaction->save();

        $this->mail->sellerRefuse($transaction->user->email);

        return $transaction;
    }

    public function doneTransaction(string $id)
    {
        $user_id = Auth::id();

        $transaction = $this->transaction
            ->where('id', $id)
            ->first();

        if (!$transaction || $transaction->user->id !== $user_id) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $transaction->status = TransactionStatus::Done;

        $transaction->save();

        return $transaction;
    }
}
