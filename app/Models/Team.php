<?php

namespace App\Models;

use App\Enums\TeamStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The technician that belong to the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function technician(): BelongsToMany
    {
        return $this->belongsToMany(Technician::class, 'team_technician', 'team_id', 'technician_id')->withPivot(['status'])->withTimestamps();
    }
    /**
     * The skill that belong to the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skill(): BelongsToMany
    {
        return $this->belongsToMany(Master_skill::class, 'team_skill', 'team_id', 'master_skill_id')->withTimestamps();
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'team_order', 'team_id', 'order_id')->withPivot(['status_team'])->withTimestamps();
    }

    public function scopeAvailableTeams($query, $desiredDateTime)
    {
        $bufferDateTime = date('Y-m-d H:i:s', strtotime($desiredDateTime . ' +2 hours'));
        return $query->whereDoesntHave('orders', function ($query) use ($desiredDateTime, $bufferDateTime) {
            $query->where('booked_date', '>=', $desiredDateTime)
                ->where('booked_date', '<=', $bufferDateTime)
                ->where('order_status', '!=', 6); // Exclude completed orders
        });
    }

    public function getStatusTeamAttribute(){
        return TeamStatus::label()[$this->status];
    }

    public function getCountTeamOrderTodayAttribute(){
        return $this->orders()->whereDate('booked_date', date('Y-m-d'))->count();
    }

    public function scopeMostOrderTeamThisMonth():array{
        // Get the current month
        $currentMonth = Carbon::now()->month;

        // Search for the teams with the most orders in the current month
        $teamsWithMostOrders = $this
        ->withCount(['orders' => function ($query) use ($currentMonth) {
            $query->whereMonth('booked_date', $currentMonth);
        }])
        ->get();
        // Retrieve the highest orders count
        $highestOrdersCount = $teamsWithMostOrders->max('orders_count');
        // Filter the teams to only include those with the highest orders count
        $teamsWithHighestOrders = $teamsWithMostOrders->where('orders_count', $highestOrdersCount);
        return [
            'teams'=>$teamsWithHighestOrders,
            'orders_count'=>$highestOrdersCount,
        ];
    }
    public function scopeFewestOrderTeamThisMonth():array{
        // Get the current month
        $currentMonth = Carbon::now()->month;

        // Search for the teams with the most orders in the current month
        $teamsWithMostOrders = $this
        ->withCount(['orders' => function ($query) use ($currentMonth) {
            $query->whereMonth('booked_date', $currentMonth);
        }])
        ->get();
        // Retrieve the highest orders count
        $highestOrdersCount = $teamsWithMostOrders->min('orders_count');
        // Filter the teams to only include those with the highest orders count
        $teamsWithHighestOrders = $teamsWithMostOrders->where('orders_count', $highestOrdersCount);
        return [
            'teams'=>$teamsWithHighestOrders,
            'orders_count'=>$highestOrdersCount,
        ];
    }


}
