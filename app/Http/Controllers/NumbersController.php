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
        // Validasi input untuk memastikan n1 dan n2 dalam rentang yang benar
        $validatedData = $request->validate([
            'n1' => 'required|integer|min:0|max:40',
            'n2' => 'required|integer|min:0|max:40',
        ]);

        // Ambil nilai n1 dan n2 dari request
        $n1 = $validatedData['n1'];
        $n2 = $validatedData['n2'];

        $fibo1 = $this->fibonacci($n1);
        $fibo2 = $this->fibonacci($n2);
        $result = $fibo1 + $fibo2;

        return view('transactions.fibonacci', compact('n1', 'n2', 'fibo1', 'fibo2', 'result'));
    }
}
