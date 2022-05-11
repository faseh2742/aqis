<?php


namespace App\Actions;


use App\Clientmeeting;
use App\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MonthlyReport
{
//    public function execute($startYearMonthly, $startMonthMonthly, $endYearMonthly, $endMonthMonthly)
    public function execute($start, $end)
    {

        $startDate = Carbon::create($start);
        $endDate = Carbon::create($end);

        $yearStart = $this->getYearStart($start);
        $yearEnd = $this->getYearEnd($end);

        $meetingsByRange = Clientmeeting::
        where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->where('status', 'Attended')
            ->where('funder', 'IRCC')
            ->where('programName', 'AQIS')
            ->with(['client.user', 'client.highestEducation', 'clientaps:id,client_id,clientmeeting_id,noc', 'clientaps.client:id,wc_id,user_id',
                'clientaps.client.user:id,client_id,firstName,lastName', 'clientaps.referrals:referrals.id,name'])
            ->get();
        foreach ($meetingsByRange as $meeting) {
            foreach ($meeting->clientaps as $clientap) {
                $clientap->noc = unserialize($clientap->noc);
            }
        }

        $meetingTotalCount = $meetingsByRange->count();

        $meetingYtd = Clientmeeting::
        where('date', '>=', $yearStart)
            ->where('date', '<=', $yearEnd)
            ->with('Client')
            ->get();

        $author = Auth::user();

        $meetingInitial = $meetingsByRange->where('type', 'Initial');
        $meetingInitialCount = $meetingInitial->count();
        $meetingRepeat = $meetingsByRange->where('type', 'Repeat');
        $meetingRepeatCount = $meetingRepeat->count();

        $events = Event::where('start', '>=', $startDate)
            ->where('end', '<=', $endDate)
            ->whereHas('groupActivity', function (Builder $query) {
                $query->where('funder', 'IRCC')
                    ->where('programName', 'AQIS');
            })
            ->with(['groupActivity', 'attendances.user:id,client_id,firstName,lastName'])
            ->get();

        $locations = $this->getLocations($meetingsByRange);

        $workshops = $this->getWorkshops($events);

        $forums = $this->getForums($events);

        $groupSessions = $this->getGroupSessions($events);

        $cities = $this->getCities($meetingInitial);

        $genders = $this->getGenders($meetingInitial);

        $immigrationStatuses = $this->getImmigrationStatuses($meetingInitial);

        $countriesOrigin = $this->getCountriesOrigin($meetingInitial);

        $motherTongues = $this->getMotherTongues($meetingInitial);

        $highestEducaitons = $this->getHighestEducations($meetingsByRange);

        $nocs = $this->getNocs($meetingsByRange);

        $ageRanges = $this->getAges($meetingsByRange);

        $referrals = $this->getReferrals($meetingsByRange);

        return collect(['meetingInitial' => $meetingInitial,
            'meetingRepeat' => $meetingRepeat,
            'meetingsByRange' => $meetingsByRange,
            'meetingYtd' => $meetingYtd,
            'author'=>$author,
            'meetingInitialCount' => $meetingInitialCount,
            'meetingRepeatCount' => $meetingRepeatCount,
            'meetingTotalCount' => $meetingTotalCount,
            'locations' => $locations,
            'workshops' => $workshops,
            'forums' => $forums,
            'groupSessions' => $groupSessions,
            'cities' => $cities,
            'genders' => $genders,
            'ageRanges' => $ageRanges,
            'immigrationStatuses' => $immigrationStatuses,
            'countriesOrigin' => $countriesOrigin,
            'motherTongues' => $motherTongues,
            'highestEducations' => $highestEducaitons,
            'nocs' => $nocs,
            'referrals' => $referrals
        ]);
    }

    private function getYearStart($date)
    {
        $date = Carbon::parse($date);
        $month = $date->month;
        $year = $date->year;

        if ($month > 4) {
            return Carbon::create($year-1, 1, 1, null);
        }

        return new Carbon('first day of April '. $year);
    }

    private function getYearEnd($date)
    {
        $date = Carbon::parse($date);
        $month = $date->month;
        $year = $date->year;

        if ($month > 4) {
            return new Carbon('last day of March '. $year);
        }

        return Carbon::create($year+1, 03, 31, null);
    }

    private function getLocations($meetings)
    {
        $locations = $meetings->sortBy('location')->groupBy('location')->map( function ($item) {
            return array_merge(array("newClientCount" => $item->where('type', 'Initial')->count()),
                array("repeatClientCount" => $item->where('type', 'Repeat')->count()),
                array("initialRecords" => $item->where('type', 'Initial')),
                array("repeatRecords" => $item->where('type', 'Repeat')),
                array("records" => $item->all())
            );
        });

        return $locations;
    }

    private function getSectorInfoSessions($groupActivities)
    {
        $sectorActivities = $groupActivities->where('description', 'Sector Specific: Accounting and Finance')
            ->orWhere('description', 'Sector Specific: Engineering')
            ->orWhere('description', 'Sector Specific: Health Care')
            ->orWhere('description', 'Sector Specific: Supply Chain');

        $sectorActivities = $sectorActivities->groupBy('description')->map(function ($item) {

        });
    }

    private function getWorkshops($events)
    {
        $workshops = collect();
        $attendessCount = 0;

        foreach ($events as $event) {
            if ($event->groupActivity['type'] === 'Workshop') {
                $workshops->push($event);
            }
        }

        foreach ($workshops as $workshop) {
            $workshop->participants = $workshop->attendances->count();
            $attendessCount = $attendessCount+$workshop->participants;
        }

        $workshops = array_merge(array("workshopCount" => $workshops->count()),
            array("workshops" => $workshops),
            array("attendeesCount" => $attendessCount)
        );

        return $workshops;
    }

    private function getForums($events)
    {
        $forums = collect();
        $attendessCount = 0;

        foreach ($events as $event) {
            if ($event->groupActivity['type'] === 'Forum') {
                $forums->push($event);
            }
        }

        foreach ($forums as $forum) {
            $forum->participants = $forum->attendances->count();
            $attendessCount = $attendessCount+$forum->participants;
        }

        $forums = array_merge(array("forumCount" => $forums->count()),
            array("forums" => $forums),
            array("attendeesCount" => $attendessCount)
        );

        return $forums;
    }

    private function getGroupSessions($events)
    {
        $groupSessions = collect();
        $attendessCount = 0;

        foreach ($events as $event) {
            if ($event->groupActivity['type'] === 'Group Session') {
                $groupSessions->push($event);
            }
        }

        foreach ($groupSessions as $groupSession) {
            $groupSession->participants = $groupSession->attendances->count();
            $attendessCount = $attendessCount+$groupSession->participants;
        }

        $groupSessions = array_merge(array("groupSessionCount" => $groupSessions->count()),
            array("groupSessions" => $groupSessions),
            array("attendeesCount" => $attendessCount)
        );

        return $groupSessions;
    }

    private function getCities($meetings)
    {
        $allClients = collect();
        $meetings->each(function ($meeting) {
            if ($meeting['client']['city'] == "") {
                $meeting['client']['city'] = " NOT PROVIDED";
            }
        });
        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                $allClients->push($meeting->client);
            }
        }

        $cities = $allClients->unique()->groupBy('city')->map( function ($item) {
            return array_merge(array("count" => $item->count()),
                array("records" => $item->all())
            );
        });
        $cities = $cities->sortByDesc('count');

        return $cities;
    }

    private function getGenders($meetings)
    {
        $allClients = collect();
        $meetings->each(function ($meeting) {
            if ($meeting['client']['gender'] == "" || $meeting['client']['gender'] == null) {
                $meeting['client']['gender'] = " NOT PROVIDED";
            }
        });
        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                $allClients->push($meeting->client);
            }
        }

        $genders = $allClients->unique()->groupBy('gender')->map( function ($item) {
            return array_merge(array("count" => $item->count()),
                array("records" => $item->all())
            );
        });
        $genders = $genders->sortByDesc('count');

        return $genders;
    }

    private function getImmigrationStatuses($meetings)
    {
        $allClients = collect();
        $meetings->each(function ($meeting) {
            if ($meeting['client']['immigrationStatus'] == "") {
                $meeting['client']['immigrationStatus'] = " NOT PROVIDED";
            }
        });
        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                $allClients->push($meeting->client);
            }
        }

        $statuses = $allClients->unique()->groupBy('immigrationStatus')->map( function ($item) {
            return array_merge(array("count" => $item->count()),
                array("records" => $item->all())
            );
        });
        $statuses = $statuses->sortByDesc('count');

        return $statuses;
    }

    private function getCountriesOrigin($meetings)
    {
        $allClients = collect();
        $meetings->each(function ($meeting) {
            if ($meeting['client']['countryOrigin'] == "") {
                $meeting['client']['countryOrigin'] = " NOT PROVIDED";
            }
        });
        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                $allClients->push($meeting->client);
            }
        }

        $countries = $allClients->unique()->groupBy('countryOrigin')->map( function ($item) {
            return array_merge(array("count" => $item->count()),
                array("records" => $item->all())
            );
        });
        $countries = $countries->sortByDesc('count');

        return $countries;
    }

    private function getMotherTongues($meetings)
    {
        $allClients = collect();
        $meetings->each(function ($meeting) {
            if ($meeting['client']['motherTongue'] == "") {
                $meeting['client']['motherTongue'] = " NOT PROVIDED";
            }
        });
        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                $allClients->push($meeting->client);
            }
        }

        $motherTongues = $allClients->unique()->groupBy('motherTongue')->map(function ($item) {
            return array_merge(array("count" => $item->count()),
                array("records" => $item->all()));
        });
        $motherTongues = $motherTongues->sortByDesc('count');

        return $motherTongues;
    }

    private function getHighestEducations($meetings)
    {
        $allEducations = collect();
        $allClients = collect();

        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                if ($meeting->client->highestEducation) {
                    if ($meeting->client->highestEducation) {
                        $allClients->push($meeting->client);
                    }
                }
            }

        }
        $uniqueClients = $allClients->unique();

        foreach ($uniqueClients as $client) {
            $allEducations->push($client['highestEducation']);
        }

        $highestEducations = $allEducations->groupBy('education_level')->map(function ($group) {
            return array("count" => $group->count());
        });

        $highestEducations = $highestEducations->sortByDesc('count');
        $total = $highestEducations->sum('count');
        $highestEducations = array_merge(array("educations" => $highestEducations), array("total" => $total));

        return $highestEducations;
    }

    private function getNocs($meetings)
    {
        $allClientAps = collect();

        foreach ($meetings as $meeting) {
            if (count($meeting->clientaps) > 0) {
                foreach ($meeting->clientaps as $clientap) {
                    $allClientAps->push($clientap);
                }
            }
        }
        $nocs = $allClientAps->groupBy('noc.title')->map(function ($item) {
            return array_merge(array("code"=>$item->first()->noc['code']),
                array("title" => $item->first()->noc['title']),
                array("count" => $item->count()),
                array("records" => $item->all())
            );
        });

        $nocs = $nocs->sortByDesc("count");


        $allNocs = collect(["nocs"=> $nocs, "count" => $allClientAps->count()]);

        return $allNocs;
    }

    private  function getAges($meetings)
    {
        $allClients = collect();

        foreach ($meetings as $meeting) {
            if ($meeting->type === 'Initial') {
                $allClients->push($meeting->client);
            }
        }

        foreach ($allClients as $client) {
            if ($client->dob) {
                $client->age = Carbon::create($client->dob)->diffInYears(Carbon::now());
            } else {
                $client->age = "Unknown";
            }
        }

        $seventeenToTwentyfour = collect();
        $twentyfiveToThirtyfour = collect();
        $thirtyfiveToFourtyfive = collect();
        $fourtysixToFiftynine = collect();
        $sixtyPlus = collect();
        $unknown = collect();

        foreach ($allClients as $client) {
            if ($client->age >= 17 && $client->age <= 24) {
                $seventeenToTwentyfour->push($client);
            } elseif ($client->age >= 25 && $client->age <= 34) {
                $twentyfiveToThirtyfour->push($client);
            } elseif ($client->age >= 35 && $client->age <= 45) {
                $thirtyfiveToFourtyfive->push($client);
            } elseif ($client->age >= 46 && $client->age <= 59) {
                $fourtysixToFiftynine->push($client);
            } elseif ($client->age >= 60) {
                $sixtyPlus->push($client);
            } else {
                $unknown->push($client);
            }
        }

        $ageRanges = array_merge(array("seventeenToTwentyfour" => array("records" => $seventeenToTwentyfour, "count" => $seventeenToTwentyfour->count() )),
            array("twentyfiveToThirtyfour" => array("records" => $twentyfiveToThirtyfour, "count" => $twentyfiveToThirtyfour->count() )),
            array("thirtyfiveToFourtyfive" => array("records" => $thirtyfiveToFourtyfive, "count" => $thirtyfiveToFourtyfive->count())),
            array("fourtySixToFiftynine" => array("records" => $fourtysixToFiftynine, "count" => $fourtysixToFiftynine->count())),
            array("sixtyPlus" => array("records" => $sixtyPlus, "count" => $sixtyPlus->count())),
            array("Unknown" => array("records" => $unknown, "count" => $unknown->count()))
        );

        return $ageRanges;
    }

    private function getReferrals($meetings)
    {
        $referrals = collect();

        foreach ($meetings as $meeting) {
            if ($meeting->clientaps) {
                foreach ($meeting->clientaps as $clientap) {
                    foreach ($clientap->referrals as $referral) {
                        $referrals->push($referral);
                    }
                }
            }
        }

        $referralsGrouped = $referrals->groupBy('name')->map(function ($group) {
            return $group->count();
        });

        $total = $referralsGrouped->sum();

        $referralsGrouped = $referralsGrouped->sortDesc();

        $referralsGrouped->put('total', $total);

        return $referralsGrouped;
    }

}
