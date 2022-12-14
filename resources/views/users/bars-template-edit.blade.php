@extends('layouts.base')
@section('title', 'Bars Edit - ' . config('app.name'))
@section('content')
    <div class="main-content" id="prod-edit-page" v-cloak>
        <div class="show-loading" v-if="loading"></div>
        @include('layouts.page-header', ['data' => $header_data])
        {{-- Page content --}}
        <div class="container-fluid mt--8">
            <form :action="form_action" method="post" id="edit-form" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="_method" value="PUT" v-if="!create_edit"/>
                <input type="hidden" name="sel_tab" v-model="model.sel_tab"/>
                <input type="hidden" name="template_name" v-model="model.template_name"/>
                {{-- bar Base Content --}}
                @include('users.bars-partials.bars-editor-tabs')
            </form>
            @include('users.bars-partials.bars-preview')
            <div style="opacity: 0.01;height: 1px;" v-if="capturing">
                @include('users.bars-partials.bars-capture')
            </div>
            <div class="modal fade" id="group-add-modal" tabindex="-1" role="dialog" aria-labelledby="group-add-modal" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-default">Quick Add Group</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-control-label ml-1" for="group_name">Group Name</label>
                                <input type="text" class="form-control" id="group_name" v-model="group_name" placeholder="Your Group Name"/>
                                <span class="invalid-feedback" role="alert">
                                    @{{ error_message }}
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success bg-cp text-capitalize" @click="quickAddGroup">Add</button>
                            <button type="button" class="btn btn-light ml-auto" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="template-save-modal" tabindex="-1" role="dialog" aria-labelledby="template-save-modal" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-default">Save as Template</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-control-label ml-1" for="template_name">Template Name</label>
                                <input type="text" class="form-control" id="template_name" v-model="model.template_name" placeholder="Template Name"/>
                                <span class="invalid-feedback" role="alert">
                                    @{{ error_message }}
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success bg-cp text-capitalize" @click="saveAsTemplate">Save</button>
                            <button type="button" class="btn btn-light ml-auto" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        window._bar_opt_ary = {
            bar_id: "",
            create_edit: true,
            form_action: "{{ $form_action }}",
            model: {
                sel_tab: "{{ (old('sel_tab') ? old('sel_tab') : $sel_tab) }}",
                friendly_name: "{{ (old('friendly_name') ? old('friendly_name') : $bar->template_name . ' - Custom') }}",
                position: "{{ old('position') ? old('position') : $bar->position }}",
                group_id: "{{ old('group_id') ? old('group_id') : $bar->group_id }}",
                group_list: JSON.parse('{!! json_encode($group_list) !!}'),
                headline: JSON.parse('{!! $bar->headline !!}'),
                headline_color: "{{ old('headline_color') ? old('headline_color') : $bar->headline_color }}",
                background_color: "{{ old('background_color') ? old('background_color') : $bar->background_color }}",
                show_bar_type: "{{ old('show_bar_type') ? old('show_bar_type') : $bar->show_bar_type }}",
                frequency: "{{ old('frequency') ? old('frequency') : $bar->frequency }}",
                delay_in_seconds: "{{ old('delay_in_seconds') ? old('delay_in_seconds') : $bar->delay_in_seconds }}",
                scroll_point_percent: "{{ old('scroll_point_percent') ? old('scroll_point_percent') : $bar->scroll_point_percent }}",
                appearance: {
                    opacity: "{{ old('opacity') ? old('opacity') : $bar->opacity }}",
                    drop_shadow: "{{ old('drop_shadow') ? old('drop_shadow') : $bar->drop_shadow }}",
                    close_button: "{{ old('close_button') ? old('close_button') : $bar->close_button }}",
                    background_gradient: "{{ old('background_gradient') ? old('background_gradient') : $bar->background_gradient }}",
                    gradient_end_color: "{{ old('gradient_end_color') ? old('gradient_end_color') : $bar->gradient_end_color }}",
                    gradient_angle: "{{ old('gradient_angle') ? old('gradient_angle') : $bar->gradient_angle }}",
                    powered_by_position: "{{ old('powered_by_position') ? old('powered_by_position') : $bar->powered_by_position }}",
                },
                content: {
                    sub_headline: JSON.parse('{!! $flag ? json_encode([['attributes' => [], 'insert' => '']]) : $bar->sub_headline !!}'),
                    sub_headline_color: "{{ old('sub_headline_color') ? old('sub_headline_color') : $bar->sub_headline_color }}",
                    sub_background_color: "{{ old('sub_background_color') ? old('sub_background_color') : $bar->sub_background_color }}",
                    video_type: "{{ old('video_type') ? old('video_type') : $bar->video_type }}",
                    content_youtube_url: "{{ old('content_youtube_url') ? old('content_youtube_url') : $bar->content_youtube_url }}",
                    content_vimeo_url: "{{ old('content_vimeo_url') ? old('content_vimeo_url') : $bar->content_vimeo_url }}",
                    video_code: "{{ old('video_code') ? old('video_code') : $bar->video_code }}",
                    video_auto_play: "{{ old('video_auto_play') ? old('video_auto_play') : $bar->video_auto_play }}",
                    button_type: "{{ old('button_type') ? old('button_type') : $bar->button_type }}",
                    button_location: "{{ old('button_location') ? old('button_location') : $bar->button_location }}",
                    button_label: "{{ old('button_label') ? old('button_label') : $bar->button_label }}",
                    button_background_color: "{{ old('button_background_color') ? old('button_background_color') : $bar->button_background_color }}",
                    button_text_color: "{{ old('button_text_color') ? old('button_text_color') : $bar->button_text_color }}",
                    button_animation: "{{ old('button_animation') ? old('button_animation') : $bar->button_animation }}",
                    button_action: "{{ old('button_action') ? old('button_action') : $bar->button_action }}",
                    button_click_url: "{{ old('button_click_url') ? old('button_click_url') : $bar->button_click_url }}",
                    button_open_new: "{{ old('button_open_new') ? old('button_open_new') : $bar->button_open_new }}",
                    social_button_type: "{{ old('social_button_type') ? old('social_button_type') : $bar->social_button_type }}",
                },
                timer: {
                    countdown: "{{ old('countdown') ? old('countdown') : $bar->countdown }}",
                    countdown_location: "{{ old('countdown_location') ? old('countdown_location') : $bar->countdown_location }}",
                    countdown_format: "{{ old('countdown_format') ? old('countdown_format') : $bar->countdown_format }}",
                    countdown_end_date: "{{ old('countdown_end_date') ? old('countdown_end_date') : $bar->countdown_end_date }}",
                    countdown_end_time: "{{ old('countdown_end_time') ? old('countdown_end_time') : $bar->countdown_end_time }}",
                    countdown_timezone: "{{ old('countdown_timezone') ? old('countdown_timezone') : $bar->countdown_timezone }}",
                    countdown_days: "{{ old('countdown_days') ? old('countdown_days') : $bar->countdown_days }}",
                    countdown_hours: "{{ old('countdown_hours') ? old('countdown_hours') : $bar->countdown_hours }}",
                    countdown_minutes: "{{ old('countdown_minutes') ? old('countdown_minutes') : $bar->countdown_minutes }}",
                    countdown_background_color: "{{ old('countdown_background_color') ? old('countdown_background_color') : $bar->countdown_background_color }}",
                    countdown_text_color: "{{ old('countdown_text_color') ? old('countdown_text_color') : $bar->countdown_text_color }}",
                    countdown_on_expiry: "{{ old('countdown_on_expiry') ? old('countdown_on_expiry') : $bar->countdown_on_expiry }}",
                    countdown_expiration_text: "{{ old('countdown_expiration_text') ? old('countdown_expiration_text') : $bar->countdown_expiration_text }}",
                    countdown_expiration_url: "{{ old('countdown_expiration_url') ? old('countdown_expiration_url') : $bar->countdown_expiration_url }}",
                },
                overlay: {
                    third_party_url: "{{ old('third_party_url') ? old('third_party_url') : $bar->third_party_url }}",
                    custom_link: "{{ old('custom_link') ? old('custom_link') : $bar->custom_link }}",
                    custom_link_text: "{{ old('custom_link_text') ? old('custom_link_text') : $bar->custom_link_text }}",
                    meta_title: "{{ old('meta_title') ? old('meta_title') : $bar->meta_title }}",
                    meta_description: "{{ old('meta_description') ? old('meta_description') : $bar->meta_description }}",
                    meta_keywords: "{{ old('meta_keywords') ? old('meta_keywords') : $bar->meta_keywords }}",
                },
                lead_capture: {
                    integration_type: "{{ old('integration_type') ? old('integration_type') : $bar->integration_type }}",
                    list: "{{ old('list') ? old('list') : $bar->list }}",
                    after_submit: "{{ old('after_submit') ? old('after_submit') : $bar->after_submit }}",
                    message: "{{ old('message') ? old('message') : $bar->message }}",
                    autohide_delay_seconds: "{{ old('autohide_delay_seconds') ? old('autohide_delay_seconds') : $bar->autohide_delay_seconds }}",
                    redirect_url: "{{ old('redirect_url') ? old('redirect_url') : $bar->redirect_url }}",
                    opt_in_type: "{{ old('opt_in_type') ? old('opt_in_type') : $bar->opt_in_type }}",
                    opt_in_youtube_url: "{{ old('opt_in_youtube_url') ? old('opt_in_youtube_url') : $bar->opt_in_youtube_url }}",
                    opt_in_vimeo_url: "{{ old('opt_in_vimeo_url') ? old('opt_in_vimeo_url') : $bar->opt_in_vimeo_url }}",
                    opt_in_video_code: "{{ old('opt_in_video_code') ? old('opt_in_video_code') : $bar->opt_in_video_code }}",
                    opt_in_video_auto_play: "{{ old('opt_in_video_auto_play') ? old('opt_in_video_auto_play') : $bar->opt_in_video_auto_play }}",
                    image_url: "{{ old('image_url') ? old('image_url') : $bar->image_url }}",
                    image_upload: "{{ old('image_upload') ? old('image_upload') : $bar->image_upload }}",
                    call_to_action: JSON.parse('{!! $bar->call_to_action !!}'),
                    panel_color: "{{ old('panel_color') ? old('panel_color') : $bar->panel_color }}",
                    subscribe_text: JSON.parse('{!! $bar->subscribe_text !!}'),
                    subscribe_text_color: "{{ old('subscribe_text_color') ? old('subscribe_text_color') : $bar->subscribe_text_color }}",
                    opt_in_button_type: "{{ old('opt_in_button_type') ? old('opt_in_button_type') : $bar->opt_in_button_type }}",
                    opt_in_button_label: "{{ old('opt_in_button_label') ? old('opt_in_button_label') : $bar->opt_in_button_label }}",
                    opt_in_button_bg_color: "{{ old('opt_in_button_bg_color') ? old('opt_in_button_bg_color') : $bar->opt_in_button_bg_color }}",
                    opt_in_button_label_color: "{{ old('opt_in_button_label_color') ? old('opt_in_button_label_color') : $bar->opt_in_button_label_color }}",
                    opt_in_button_animation: "{{ old('opt_in_button_animation') ? old('opt_in_button_animation') : $bar->opt_in_button_animation }}",
                },
                auto_responder_list: JSON.parse('{!! $list_array !!}'),
                translation: {
                    days_label: "{{ old('days_label') ? old('days_label') : $bar->days_label }}",
                    hours_label: "{{ old('hours_label') ? old('hours_label') : ($flag ? 'Hours' : $bar->hours_label) }}",
                    minutes_label: "{{ old('minutes_label') ? old('minutes_label') : $bar->minutes_label }}",
                    seconds_label: "{{ old('seconds_label') ? old('seconds_label') : $bar->seconds_label }}",
                    opt_in_name_placeholder: "{{ old('opt_in_name_placeholder') ? old('opt_in_name_placeholder') : $bar->opt_in_name_placeholder }}",
                    opt_in_email_placeholder: "{{ old('opt_in_email_placeholder') ? old('opt_in_email_placeholder') : $bar->opt_in_email_placeholder }}",
                    powered_by_label: "{{ old('powered_by_label') ? old('powered_by_label') : $bar->powered_by_label }}",
                    disclaimer: "{{ old('disclaimer') ? old('disclaimer') : $bar->disclaimer }}",
                },
                template_name: ""
            }
        };
    </script>
    <script type="text/javascript" src="{{ url(mix('js/slider-edit.js')) }}"></script>
@stop
