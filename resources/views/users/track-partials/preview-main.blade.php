<div style="width:100%; font-size: 20px; font-family: Nunito, sans-serif; color: rgb(255, 255, 255); position: relative; min-height: 76px;
    background-color: {{ $bar->background_gradient ? "none" : (strpos($bar->background_color, "#") === false ? "#" . $bar->background_color : $bar->background_color) }};
    background-image: {{ $bar->background_gradient ? ("linear-gradient(" . $bar->gradient_angle . "deg, " . (strpos($bar->background_color, "#") === false ? "#" . $bar->background_color : $bar->background_color) . ", " . (strpos($bar->gradient_end_color, "#") === false ? "#" . $bar->gradient_end_color : $bar->gradient_end_color) . ")") : "none" }};
    opacity: {{ ($bar->opacity / 100) }}; box-shadow: {{ $bar->drop_shadow ? "0 10px 10px -10px #120f0f" : "none" }}">
    @if (!$bar->close_button)
        <div id="main--cp-bar-close-btn-{{ $bar->id }}" class="cp--bar--close-btn" style="position: absolute; top: -4px; right: 6px;font-size: 24px;z-index: 9999;
            color: {{ (strpos($bar->headline_color, "#") === false ? "#" . $bar->headline_color : $bar->headline_color) }};">&times;
        </div>
    @endif
    @if ($bar->countdown != "none" && $bar->countdown_location === "left_edge")
        <div style="width: auto; height: 100%; min-height: 40px; top: 0; left: 0; position: absolute;">
            <div style="width: auto;min-height: 40px;height: 100%;display: flex;align-items: center;justify-content: left;
                background-color: {{ $bar->countdown_background_color == "" ? "transparent" : (strpos($bar->countdown_background_color, "#") === false ? "#" . $bar->countdown_background_color : $bar->countdown_background_color) }};">
                <div style="width: 100%">
                    {{--Countdown Edge Top Here--}}
                    @include("users.track-partials.countdown-edge-top")
                    {{--Countdown Edge Bottom Here--}}
                    @include("users.track-partials.countdown-edge-bottom")
                </div>
            </div>
        </div>
    @endif
    <style type="text/css">
        .cp--main-div {
            width: 100%;
            font-size: 20px;
            font-family: "Nunito", sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 76px;
        }
    </style>
    <div class="cp--main-div" style="">
        {{--Preview Video Here--}}
        @include("users.track-partials.preview-video")
        
        @if (($bar->button_type != "none" && $bar->button_location == "left") || ($bar->countdown != "none" && $bar->countdown_location == "left"))
            <div style="display: inline-block; width:auto; margin-right: 20px;padding: 10px 0;text-align: center;">
                @if (($bar->button_type != "none" && $bar->button_location == "left"))
                    <div style="width: 100%; min-width: 100%;">
                        {{--Preview Button Here--}}
                        @include("users.track-partials.preview-button")
                    </div>
                @endif
                @if (($bar->countdown != "none" && $bar->countdown_location == "left"))
                    <div style="width:100%; height:40px; min-height:40px; margin-top:5px;">
                        <div style="height: 40px; width: 100%;">
                            {{--Preview Countdown Top--}}
                            @include("users.track-partials.countdown-top")
                            {{--Preview Countdown Bottom--}}
                            @include("users.track-partials.countdown-bottom")
                        </div>
                    </div>
                @endif
            </div>
        @endif
        <div style="display:inline-block; vertical-align:top; width:auto; text-align:center;">
            <div style="display:inline-block; width:auto;">
                <div style="width: 100%; min-width: 100%; margin:0 auto; font-size: 1.8rem;
                    color: {{ (strpos($bar->headline_color, "#") === false ? "#" . $bar->headline_color : $bar->headline_color) }};">
                    @foreach(json_decode($bar->headline, true) as $h_row)
                        @if (trim($h_row["insert"]) != "")
                            <span>
                                @if (isset($h_row["attributes"]))
                                    <span style="font-weight: {{ isset($h_row["attributes"]["bold"]) ? "bold" : "normal" }};
                                        font-style: {{ isset($h_row["attributes"]["italic"]) ? "italic" : "normal" }};
                                        text-decoration: {{ (isset($h_row["attributes"]["underline"]) && isset($h_row["attributes"]["strike"])) ? "underline line-through" :
                                            ((isset($h_row["attributes"]["underline"]) && !isset($h_row["attributes"]["strike"])) ? "underline" :
                                            ((!isset($h_row["attributes"]["underline"]) && isset($h_row["attributes"]["strike"])) ? "line-through" : "normal")) }};">
                                        {{ stripslashes($h_row["insert"]) }}
                                    </span>
                                @else
                                    <span>
                                        {{ stripslashes($h_row["insert"]) }}
                                    </span>
                                @endif
                            </span>
                        @endif
                    @endforeach
                </div>
                @if (trim(json_decode($bar->sub_headline, true)[0]["insert"]) != "")
                    <div style="width: 100%; min-width: 100%; margin: 0 0 5px auto; font-size: 18px;
                        color: {{ (strpos($bar->sub_headline_color, "#") === false ? "#" . $bar->sub_headline_color : $bar->sub_headline_color) }};
                        background-color: {{ $bar->sub_background_color == "" ? "transparent" : (strpos($bar->sub_background_color, "#") === false ? "#" . $bar->sub_background_color : $bar->sub_background_color) }};">
                        @foreach(json_decode($bar->sub_headline, true) as $s_h_row)
                            <span>
                                @if (isset($s_h_row["attributes"]))
                                    <span style="font-weight: {{ isset($s_h_row["attributes"]["bold"]) ? "bold" : "normal" }};
                                        font-style: {{ isset($s_h_row["attributes"]["italic"]) ? "italic" : "normal" }};
                                        text-decoration: {{ (isset($s_h_row["attributes"]["underline"]) && isset($s_h_row["attributes"]["strike"])) ? "underline line-through" :
                                            ((isset($s_h_row["attributes"]["underline"]) && !isset($s_h_row["attributes"]["strike"])) ? "underline" :
                                            ((!isset($s_h_row["attributes"]["underline"]) && isset($s_h_row["attributes"]["strike"])) ? "line-through" : "normal")) }};">
                                        {{ stripslashes($s_h_row["insert"]) }}
                                    </span>
                                @else
                                    <span>
                                        {{ stripslashes($s_h_row["insert"]) }}
                                    </span>
                                @endif
                            </span>
                        @endforeach
                    </div>
                @endif
                @if (($bar->button_type != "none" && $bar->button_location == "below_text") || ($bar->countdown != "none" && $bar->countdown_location == "below_text"))
                    <div style="width: 100%; min-width: 100%; margin: 0 0 5px auto; text-align: center;">
                        @if (($bar->button_type != "none" && $bar->button_location == "below_text"))
                            <div style="width: 100%; min-width: 100%;">
                                {{--Preview Button Here--}}
                                @include("users.track-partials.preview-button")
                            </div>
                        @endif
                        @if (($bar->countdown != "none" && $bar->countdown_location == "below_text"))
                            <div style="width:100%; height:40px; min-height:40px; margin-top:5px;display: flex;justify-content: center;">
                                <div style="height: 40px; width: auto;">
                                    {{--Preview Countdown Top--}}
                                    @include("users.track-partials.countdown-top")
                                    {{--Preview Countdown Bottom--}}
                                    @include("users.track-partials.countdown-bottom")
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @if (($bar->button_type != "none" && $bar->button_location == "right") || ($bar->countdown != "none" && $bar->countdown_location == "right"))
            <div style="display: inline-block; width:auto; margin-left: 20px;padding: 10px 0;text-align: center;">
                @if (($bar->button_type != "none" && $bar->button_location == "right"))
                    <div style="width: 100%; min-width: 100%;">
                        {{--Preview Button Here--}}
                        @include("users.track-partials.preview-button")
                    </div>
                @endif
                @if (($bar->countdown != "none" && $bar->countdown_location == "right"))
                    <div style="width:100%; height:40px; min-height:40px; margin-top:5px;">
                        <div style="height: 40px; width: 100%;">
                            {{--Preview Countdown Top--}}
                            @include("users.track-partials.countdown-top")
                            {{--Preview Countdown Bottom--}}
                            @include("users.track-partials.countdown-bottom")
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    @if ($bar->countdown != "none" && $bar->countdown_location == "right_edge")
        <div style="width:auto; height:100%; min-height:40px; top: 0; right: 0; position: absolute;">
            <div style="width: auto;min-height: 40px;height: 100%;display: flex;align-items: center;justify-content: left;
                background-color: {{ $bar->countdown_background_color == "" ? "transparent" : (strpos($bar->countdown_background_color, "#") === false ? "#" . $bar->countdown_background_color : $bar->countdown_background_color) }};">
                <div style="width: 100%">
                    {{--Countdown Edge Top Here--}}
                    @include("users.track-partials.countdown-edge-top")
                    {{--Countdown Edge Bottom Here--}}
                    @include("users.track-partials.countdown-edge-bottom")
                </div>
            </div>
        </div>
    @endif
    @if ($bar->powered_by_position != "hidden")
        <style type="text/css">
            .cp__power_by {
                font-size: 12px;
                line-height: 20px;
                font-family: "Arial Narrow", sans-serif;
                padding-right: 5px;
                position: absolute;
                width: auto;
                z-index: 100;
            }
        </style>
        <div class="cp__power_by" style="color: {{ (strpos($bar->headline_color, "#") === false ? "#" . $bar->headline_color : $bar->headline_color) }};
            bottom: {{ ($bar->powered_by_position == "bottom_left" || $bar->powered_by_position == "bottom_right") ? 0 : "auto" }};
            right: {{ ($bar->powered_by_position == "bottom_right") ? 0 : "auto" }};
            top: {{ ($bar->powered_by_position == "top_left") ? "1px" : "auto" }};
            left: {{ ($bar->powered_by_position == "top_left" || $bar->powered_by_position == "bottom_left") ? "5px" : "auto" }};">
            <a style="color:inherit; text-decoration:inherit; text-transform: uppercase;" href="{{ config("site.home_url") }}" target="_blank">
                {{ $bar->powered_by_label }} {{ config("app.name") }}
            </a>
        </div>
    @endif
</div>
