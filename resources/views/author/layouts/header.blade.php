<!--=== Start Header===-->
<div class="tp_header_wrappo">
    <div class="tp_header">
        <div class="tp_header_inner_wrapper">
                <div class="tp_welcome">
                    <p>Hi, {{ @$auth_user->full_name }}</p>
                </div>
                <div class="tp_preview_box_wrapper">
                    <div class="tp_profile_box">
                        <span>ad</span>
                        <div class="tp_profile_open">
                            <ul>
                                <li><a href="{{ route('vendor.profile') }}"><i class="fa fa-lock" aria-hidden="true"></i>
                                        Profile</a></li>
                                <li><a href="{{ route('vendor.logout') }}"><i class="fa fa-power-off"
                                            aria-hidden="true"></i>logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tp_priview_box">
                        <p><a href="{{ route('frontend.home', app()->getLocale()) }}" target="_blank">Preview Site
                                <img src="{{ $ASSET_URL }}images/preview_icon.png" alt=""
                                    class="preview-img1">
                            </a></p>
                    </div>
                    <div class="tp_menu">
                        <div class="menu_toggle">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Header ===-->
