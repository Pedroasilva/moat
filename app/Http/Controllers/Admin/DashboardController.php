<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Establishment;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::latest()->take(5)->get();
        foreach ($users as $user) {
            $user->companyData;
            $user->userRole;
        }

        $establishments = Establishment::latest()->take(5)->get();
        $usage = $this->total_ram_cpu_usage();

        $data = [
            'users' => $users,
            'establishments' => $establishments,
            'usage' => $usage
        ];
        return view('admin.home', $data);
    }

    public function total_ram_cpu_usage()
    {
        //RAM usage
        $free = shell_exec('free'); 
        if (!is_null($free)) {
            $free = (string) trim($free);
            $free_arr = explode("\n", $free);
            $mem = explode(" ", $free_arr[1]);
            $mem = array_filter($mem);
            $mem = array_merge($mem);
            $usedmem = $mem[2];
            $usedmemInGB = number_format($usedmem / 1048576, 2) . ' GB';
            $memory1 = $mem[2] / $mem[1] * 100;
            $memory = round($memory1);
        } else {
            $memory = null;
            $usedmemInGB = null;
        }

        if (file_exists('/proc/meminfo')) {
            $fh = fopen('/proc/meminfo', 'r');
            $mem = 0;
            while ($line = fgets($fh)) {
                $pieces = array();
                if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                    $mem = $pieces[1];
                    break;
                }
            }
            fclose($fh);
            $totalram = number_format($mem / 1048576, 2) . ' GB';
        } else {
            $totalram = null;
        }
        
        //cpu usage
        $cpu_load = sys_getloadavg(); 
        if (!is_null($cpu_load)) {
            $load = $cpu_load[0] . '% / 100%';
        } else {
            $load = null;
        }

        $data = [
            'memory' => $memory,
            'totalram' => $totalram,
            'usedmemInGB' => $usedmemInGB,
            'load' => $load
        ];
        
        return $data;
    }
}
