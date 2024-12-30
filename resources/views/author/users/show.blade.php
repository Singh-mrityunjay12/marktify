@extends('author.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.user_title')</title>
@endsection
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <ul>
            <li><a href="{{route('vendor.users.index')}}">Customer List</a> </li>
            <li class="active"><a href="#">Show Customer </a></li>
        </ul>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tp_catset_box tp_catset_singleuser">
                    @if ($data->avatar)
                        <div class="mt-2">
                            <img class="rounded-pill" src="@if (!empty(@$data->avatar)) {{ @$data->avatar }} @endif"
                                alt="user-img" height="120px" width="120px">
                        </div>
                    @endif
                    <div role="tabpanel" class="tab-pane active" id="info">
                        <div class="th_content_section">
                            <div class="th_product_detail">
                                <div class="theme_label">Full Name :</div>
                                <div class="product_info product_name">{{ @$data->full_name }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Email :</div>
                                <div class="product_info status">{{ @$data->full_name }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Email Verified :</div>
                                <div class="product_info status">{{ (@$data->is_email_verified == 1)?  'Yes' : 'No' }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Mobile Number : </div>
                                <div class="product_info">{{ @$data->mobile }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Address : </div>
                                <div class="product_info">{{ @$data->address }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">City : </div>
                                <div class="product_info">{{ @$data->city }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">State : </div>
                                <div class="product_info">{{ @$data->state }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Country : </div>
                                <div class="product_info">{{ @$data->getCountry->name }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Status : </div>
                                <div class="product_info">{{ (@$data->is_active == 1) ?'Active':'Inactive';}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection