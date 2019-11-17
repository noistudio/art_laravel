<ol class="breadcrumb">
    @if(isset($current_link))
    <ol class="breadcrumb">
        <li><a href="{{route('backend/adminmenu/index')}}">{{ __('backend/adminmenu.setup_admin_menu') }}</a></li>
        <li class="active">{{ __("backend/adminmenu.edit") }}</li>
    </ol>
    @else
    <li class="active">{{ __('backend/adminmenu.setup_admin_menu') }}</li>
    @endif




</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2>{{ __('backend/adminmenu.adminmenu') }}</h2>

    </div>

    <!-- END Example Title -->

    <form action="{{route('backend/adminmenu/savestatus')}}" method="POST">
        <table class="table">


            <tr>
                <td>{{ __('backend/adminmenu.show_in_admin_panel') }}</td>
                <td>
                    <input type="checkbox"    @if(isset($menu_status) and  $menu_status) checked  @endif 
                           name="status" value="1" class="form-control" >
                </td>
            </tr>
            <tr>
                <td>@csrf</td> 
                <td><button type="submit" class="btn btn-danger" name="" value=" ">{{ __('backend/adminmenu.save') }}</button></td>
            </tr>
        </table>
    </form>

    <h4>{{ __('backend/adminmenu.links') }}</h4>

    <form action="{{$op}}" method="POST">
        <table class="table">
            <tr>
                <td>{{ __('backend/adminmenu.title') }}</td>
                <td><textarea class="form-control am_title" required  name="title">@if(isset($current_link['title'])){!! $current_link['title'] !!}@endif</textarea></td>
            </tr>

            <tr>
                <td>{{ __('backend/adminmenu.type') }}</td>
                <td><select   class=" typeadminmenu  form-control">
                        <option value="null">{{ __('backend/adminmenu.not_choosed') }}</option>
                        @if(count($links))
                        @foreach ($links as $link)

                        <option data-icon="{{ $link['icon'] }}"  data-onlyroot="{{ (int)$link['onlyroot'] }}" data-nav="{{ $link['nav'] }}" data-href="{{ $link['href'] }}" data-title="{{ $link['title'] }}" data-name_rule="{{ $link['name_rule'] }}" value="">{{ $link['title'] }}</option>

                        @endforeach 
                        @endif


                    </select></td>
            </tr>

            <tr>
                <td>{{ __('backend/adminmenu.link') }}</td>
                <td><input type="text" name="link" required class="am_href   form-control" value="@if(isset($current_link['href'])){!! $current_link['href'] !!}@endif"></td>
            </tr>

            <tr>
                <td>{{ __('backend/adminmenu.nav') }}</td>
                <td><input type="text" name="nav"   class="am_nav  form-control" value="@if(isset($current_link['nav'])){!! $current_link['nav'] !!}@endif"></td>
            </tr>

            <tr>
                <td>{{ __('backend/adminmenu.rule_title') }}</td>
                <td><input type="text" name="name_rule" class="am_name_rule   form-control" value="@if(isset($current_link['name_rule'])){!! $current_link['name_rule'] !!}@endif" ></td>
            </tr>

            <tr>
                <td>{{ __('backend/adminmenu.only_root') }}</td>
                <td>
                    <input type="checkbox" @if(isset($current_link['onlyroot']) and $current_link['onlyroot'] == true) checked @endif 

                           name="onlyroot" value="1" class="am_onlyroot form-control" >
                </td>
            </tr>
            <tr>
                <td>{{ __('backend/adminmenu.class_icon') }}</td>
                <td><input type="text" name="icon" required class="am_icon form-control" value="@if(isset($current_link['icon'])){!! $current_link['icon'] !!}@endif"></td>
            </tr>

            @if(!(isset($current_link) and is_array($current_link)))

            <tr>
                <td>{{ __('backend/adminmenu.parent') }}</td>
                <td><select name="parent" class=" form-control">
                        <option value="null">{{ __('backend/adminmenu.not_choosed') }}</option>
                        @if(count($menu))


                        @foreach ($menu as $key => $link) 


                        <option value=" {!! $key !!}"> {!! $link['title'] !!}</option>           

                        @endforeach
                        @endif

                    </select></td>
            </tr>
            @endif
            <tr>
                <td>@csrf</td>
                <td><button class = "btn btn-primary" type = "submit" name = "" value = "">{{ __('backend/adminmenu.save') }}</button></td>

            </tr>
        </table>
    </form>
    <table class = "table">
        @if(count($menu))
        @foreach($menu as $key=>$link)
        <tr> 
            <td>
                <a href="{{route('backend/adminmenu/arrows/up',array($key,"null"))}}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                {!! $key !!}
                <a href="{{route('backend/adminmenu/arrows/down',array($key,"null"))}}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
            </td>
            <td></td>
            <td>{!! $link['title'] !!}</td>
            <td>{!! $link['href'] !!}</td>
            <td><a href="{{route('backend/adminmenu/edit',array($key,"null"))}}">{{ __('backend/adminmenu.edit') }}</a></td>
            <td><a href="{{route('backend/adminmenu/delete',array($key,"null"))}}">{{ __('backend/adminmenu.delete') }}</a></td>

        </tr>
        @if(isset($link['sub_links']) and count($link['sub_links']))  
        <tr>
            <td colspan="5">{{ __('backend/adminmenu.submenu') }}:</td>
        </tr>
        @foreach($link['sub_links'] as $subkey => $children)

        <tr> 
            <td></td>
            <td>
                <a href="{{route('backend/adminmenu/arrows/up',array($key,$subkey))}}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                {!! $subkey !!}
                <a href="{{route('backend/adminmenu/arrows/down',array($key,$subkey))}}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
            </td>
            <td>{!! $children['title'] !!}</td>
            <td><a href="{{route('backend/adminmenu/edit',array($key,$subkey))}}">{{ __('backend/adminmenu.edit') }}</a></td>
            <td><a href="{{route('backend/adminmenu/delete',array($key,$subkey))}}">{{ __('backend/adminmenu.delete') }}</a></td>
        </tr>
        @endforeach
        @endif
        @endforeach
        @endif


    </table>

</div>
