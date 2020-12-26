@php use App\User; @endphp
<div class="hv-item-children">
@php $count = count($childs); --$count; @endphp
    @foreach($childs as $key => $member)

	<div class="hv-item-child  @if($key == 0) left @elseif($key == $count) right @endif">
        <!-- Key component -->
        <div class="hv-item">

	    	<div class="hv-item-parent">
	    		<a href="{{ route('levelTreeId',$member->id) }}">
	                <p class="simple-card text-center" data-toggle="tooltip" data-html="true" title="Username: <em>{{ $member->username }}</em><br>Name: <em>{{ $member->name }}</em><br>Email: <u>{{ $member->email }}</u>">
<img width="50" src="{{ url('/')}}/public/admin/images/avatar.png" alt=""><br>
                          <span>Sales Velue 1:{{ App\User::myChildLR($member->id, 1) }}</span> - <span>Sales Velue 2:{{ App\User::myChildLR($member->id, 2) }}</span>
                        </p>
	            </a>
            </div>
			@if($defth < 2 )
				@if(count($member->childs))
		            @include('pages.levelTreeChildChild',['childs' => $member->childs, 'defth' => $defth])
		        @endif
	        @endif

		</div>
    </div>
@endforeach
</div>
@php $defth++ @endphp