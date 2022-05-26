<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\ResolvedBidRequest;
use App\Mail\ReplyEmail;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class BidController extends BaseController
{

    public function create(CreateRequest $request): JsonResponse
    {
        $bid = Bid::create([
            'message' => $request->message,
            'user_id' => auth()->user()->id
        ]);

        return $this->sendResponse($bid->toArray(), 'Bid created successfully');
    }

    public function bids(): JsonResponse
    {
        $bids = Bid::all();

        return $this->sendResponse($bids->toArray(), 'Bids show successfully');;
    }

    public function getActive(): JsonResponse
    {
        $bids = Bid::all();
        $bids = $bids->where('status', 'active');

        return $this->sendResponse($bids->toArray(), 'Active bids show successfully');
    }

    public function getResolved(): JsonResponse
    {
        $bids = Bid::all();
        $bids = $bids->where('status', 'resolved');

        return $this->sendResponse($bids->toArray(), 'Resolved bids show successfully');
    }

    public function getByDate(): JsonResponse
    {
        $bids = Bid::orderBy('created_at', 'desc')->take(3)->get();

        return $this->sendResponse($bids->toArray(), 'Received successfully applications by date');
    }

    public function resolvedBid(int $id, ResolvedBidRequest $request): JsonResponse
    {
        $comment = $request->comment;
        $bid = Bid::find($id);
        $bid->resolved($comment);

        Mail::to($bid->user->email)->send(new ReplyEmail($bid->comment));

        return $this->sendResponse($bid->toArray(), 'Bid resolved successfully');
    }

    public function reply(int $id, ReplyRequest $request): JsonResponse
    {
        $user = User::find($id);
        $message = $request->message;

        Mail::to($user->email)->send(new ReplyEmail($message));

        $response = [
          'user' => $user,
          'message' => $message
        ];

        return $this->sendResponse($response, 'Message send successfully');
    }
}
