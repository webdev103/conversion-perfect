<div class="card mt--3" v-show="bar_option.countdown">
    <div class="card-header pt-2 pb-2 division-card-header">
        <div class="form-row">
            <h3 class="mb-0 col card-title">Countdown</h3>
            <div class="col text-right">
                <button v-if="show_btn.countdown" type="button" class="btn btn-sm small mr--2 no-shadow-box no-hover-transform font-weight-normal"
                        @click="saveOption('countdown')">
                    Save
                </button>
                <button v-if="!show_btn.countdown" type="button" class="btn btn-sm small mr--2 no-shadow-box no-hover-transform font-weight-normal"
                        @click="toggleOption('countdown')">
                    Hide
                </button>
                <button type="button" class="btn btn-sm small mr--2 no-shadow-box no-hover-transform font-weight-normal" @click="clearOptionConfirm('countdown')">
                    Clear
                </button>
                <input type="hidden" name="opt_countdown" v-model="bar_option.countdown"/>
            </div>
        </div>
    </div>
    <div class="card-body pb-0 pt-2">
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown">Countdown</label>
                    <select class="form-control" data-toggle="select" id="countdown" name="countdown"
                            @keydown="tabKeyPress('#countdown_location', true, $event)" @keypress="tabKeyPress('#countdown_location', true, $event)"
                            v-model="model.countdown.countdown" data-parent="countdown">
                        <option value="none">None</option>
                        <option value="calendar">Calendar</option>
                        <option value="evergreen">Evergreen</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" v-show="model.countdown.countdown !== 'none'">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_location">Location</label>
                    <select class="form-control" data-toggle="select" id="countdown_location" name="countdown_location"
                            @keydown="tabKeyPress('#countdown_format', true, $event)" @keypress="tabKeyPress('#countdown_format', true, $event)"
                            v-model="model.countdown.countdown_location" data-parent="countdown">
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                        <option value="left_edge">Left Edge</option>
                        <option value="right_edge">Right Edge</option>
                        <option value="below_text">Below Text</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" v-show="model.countdown.countdown !== 'none'">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_format">Format</label>
                    <select class="form-control" data-toggle="select" id="countdown_format" name="countdown_format"
                            @keydown="tabKeyPress('#countdown_end_date', false, $event)" @keypress="tabKeyPress('#countdown_end_date', false, $event)"
                            v-model="model.countdown.countdown_format" data-parent="countdown">
                        <option value="dd">dd hh mm ss</option>
                        <option value="hh">hh mm ss</option>
                        <option value="mm">mm ss</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-row" v-show="model.countdown.countdown === 'calendar'">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_end_date">End Date</label>
                    <input type="text" class="form-control @error('countdown_end_date') is-invalid @enderror datepicker"
                           @keydown="tabKeyPress('#countdown_end_time', false, $event)" @keypress="tabKeyPress('#countdown_end_time', false, $event)"
                           id="countdown_end_date" name="countdown_end_date" @input="showSaveBtn('countdown')" data-parent="countdown" :value="model.countdown.countdown_end_date">
                    @error('countdown_end_date')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_end_time">End Time</label>
                    <input type="time" class="form-control @error('countdown_end_time') is-invalid @enderror" placeholder="Select time"
                           @keydown="tabKeyPress('#countdown_timezone', true, $event)" @keypress="tabKeyPress('#countdown_timezone', true, $event)"
                           id="countdown_end_time" name="countdown_end_time" v-model="model.countdown.countdown_end_time"
                           @input="showSaveBtn('countdown')" data-parent="countdown">
                    @error('countdown_end_time')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4" v-show="model.countdown.countdown !== 'none'">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_timezone">Timezone</label>
                    <select class="form-control" data-toggle="select" id="countdown_timezone" name="countdown_timezone"
                            @keydown="tabKeyPress('#countdown_background_color', false, $event)" @keypress="tabKeyPress('#countdown_background_color', false, $event)"
                            v-model="model.countdown.countdown_timezone" data-parent="countdown">
                        @foreach($timezone_list as $t_key => $t_row)
                            <option value="{{ $t_key }}">{{ $t_row }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-row" v-show="model.countdown.countdown === 'evergreen'">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_days">Days</label>
                    <div class="row">
                        <div class="col-md-10 col-sm-9">
                            <vue-slider :speed="1" :min="0" :max="30" v-model="model.countdown.countdown_days" id="countdown_days" @change="showSaveBtn('countdown')"></vue-slider>
                        </div>
                        <div class="col-md-2 col-sm-3 pl-0 mt--1">@{{ model.countdown.countdown_days }}</div>
                        <input type="hidden" name="countdown_days" v-model="model.countdown.countdown_days"/>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_hours">Hours</label>
                    <div class="row">
                        <div class="col-md-10 col-sm-9">
                            <vue-slider :speed="1" :min="0" :max="23" v-model="model.countdown.countdown_hours" id="countdown_hours" @change="showSaveBtn('countdown')"></vue-slider>
                        </div>
                        <div class="col-md-2 col-sm-3 pl-0 mt--1">@{{ model.countdown.countdown_hours }}</div>
                        <input type="hidden" name="countdown_hours" v-model="model.countdown.countdown_hours"/>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_minutes">Minutes</label>
                    <div class="row">
                        <div class="col-md-10 col-sm-9">
                            <vue-slider :speed="1" :min="0" :max="59" v-model="model.countdown.countdown_minutes" id="countdown_minutes" @change="showSaveBtn('countdown')"></vue-slider>
                        </div>
                        <div class="col-md-2 col-sm-3 pl-0 mt--1">@{{ model.countdown.countdown_minutes }}</div>
                        <input type="hidden" name="countdown_minutes" v-model="model.countdown.countdown_minutes"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row" v-show="model.countdown.countdown !== 'none'">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_background_color">Background Color</label>
                    <input class="jscolor {required:false} form-control" name="countdown_background_color" id="countdown_background_color" v-model="model.countdown.countdown_background_color"
                           @change="updateJSColor('countdown_background_color', 'countdown')"
                           @keydown="tabKeyPress('#countdown_text_color', false, $event)" @keypress="tabKeyPress('#countdown_text_color', false, $event)"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_text_color">Text Color</label>
                    <input class="jscolor form-control" name="countdown_text_color" id="countdown_text_color" v-model="model.countdown.countdown_text_color"
                           @change="updateJSColor('countdown_text_color', 'countdown')"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1">&nbsp;</label>
                    <div class="w-100">
                        <button type="button" class="btn btn-light btn-sm" @click="matchMainBar">Match Main Bar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row" v-show="model.countdown.countdown !== 'none'">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_on_expiry">Expiration Action</label>
                    <select class="form-control" data-toggle="select" id="countdown_on_expiry" name="countdown_on_expiry"
                            v-model="model.countdown.countdown_on_expiry" data-parent="countdown">
                        <option value="hide_bar">Hide Bar</option>
                        <option value="redirect">Redirect to Expiration URL</option>
                        <option value="display_text">Display Expiration Text</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" v-if="model.countdown.countdown_on_expiry === 'display_text'">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_expiration_text">Expiration Text</label>
                    <input type="text" class="form-control @error('countdown_expiration_text') is-invalid @enderror"
                           id="countdown_expiration_text" name="countdown_expiration_text" @input="validationCheck('countdown_expiration_text', 'countdown')" data-parent="countdown"
                           v-model="model.countdown.countdown_expiration_text"/>
                    @error('countdown_expiration_text')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4" v-if="model.countdown.countdown_on_expiry === 'redirect'">
                <div class="form-group">
                    <label class="form-control-label ml-1" for="countdown_expiration_url">Expiration URL</label>
                    <input type="text" min="0" class="form-control @error('countdown_expiration_url') is-invalid @enderror"
                           id="countdown_expiration_url" name="countdown_expiration_url" @input="validationCheck('countdown_expiration_url', 'countdown')" data-parent="countdown"
                           v-model="model.countdown.countdown_expiration_url"/>
                    @error('countdown_expiration_url')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>