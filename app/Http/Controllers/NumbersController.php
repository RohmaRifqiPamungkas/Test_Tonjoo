<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NumbersController extends Controller
{
    // Fungsi untuk mengambil bilangan Fibonacci ke $n
    public function fibonacci($n)
    {
        if ($n == 0) return 0;
        if ($n == 1) return 1;

        $prev = 0;
        $curr = 1;

        for ($i = 2; $i <= $n; $i++) {
            $temp = $curr;
            $curr += $prev;
            $prev = $temp;
        }

        return $curr;
    }

    // Fungsi untuk menjumlahkan dua bilangan Fibonacci
    public function fibonacciSum(Request $request, $n1, $n2)
    {
        // Validasi manual input $n1 dan $n2 karena berasal dari parameter URL
        if (!is_numeric($n1) || !is_numeric($n2) || $n1 < 0 || $n2 < 0 || $n1 > 40 || $n2 > 40) {
            return response()->json(['error' => 'Invalid input. n1 and n2 must be integers between 0 and 40.'], 400);
        }

        // Lanjutkan perhitungan Fibonacci
        $fibo1 = $this->fibonacci($n1);
        $fibo2 = $this->fibonacci($n2);
        $result = $fibo1 + $fibo2;

        return view('transactions.fibonacci', compact('n1', 'n2', 'fibo1', 'fibo2', 'result'));
    }
}
