<?php

namespace App\Http\Controllers;

use DateTime;
use App\Util\Job;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class JobController extends Controller
{
    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function index()
    {
        $data = $this->job->all();
        $jobs = $this->paginate($data);
        $jobs->setPath('/job');
        return view('job.index', compact('jobs'))
                ->with('title', 'List Job');
    }

    public function detail($id)
    {
        $jobs = $this->job->detail($id);
        return view('job.detail', compact('jobs'))
                ->with('title', 'Detail Job');
    }

    public function search(Request $request)
    {
        $data=$this->job->search($request->input());
        $jobs = $this->paginate($data);
        $jobs->setPath('/job');
        return view('job.index', compact('jobs'))
                ->withInput($request->flash())
                ->with('title', 'List Job');
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
