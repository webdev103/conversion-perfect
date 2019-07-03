require('select2/dist/js/select2.min');
require('bootstrap-tagsinput/dist/bootstrap-tagsinput.min');
require('bootstrap-datepicker/dist/js/bootstrap-datepicker.min');
require('../vendor/jscolor');
import Quill from 'quill';
import PerfectScrollbar from 'perfect-scrollbar';
import Vue from 'vue';
import vueSlider from 'vue-slider-component';

new Vue({
    el: '#prod-edit-page',
    components: {
        'vue-slider': vueSlider
    },
    data: () => ({
        loading: false,
        create_edit: false,
        changed_status: false,
        bar_option: {
            preview: true, display: false, content: false, appearance: false, button: false, countdown: false, overlay: false, autoresponder: false, opt_in: false, custom_text: false
        },
        show_btn: {
            preview: false, display: false, content: false, appearance: false, button: false, countdown: false, overlay: false, autoresponder: false, opt_in: false, custom_text: false
        },
        options_list: [
            {key: 'preview', name: 'Preview', class: 'btn-outline-primary'}, {key: 'display', name: 'Display', class: 'btn-outline-default'},
            {key: 'content', name: 'Content', class: 'btn-outline-default'}, {key: 'appearance', name: 'Appearance', class: 'btn-outline-default'},
            {key: 'button', name: 'Button', class: 'btn-outline-default'}, {key: 'countdown', name: 'Countdown', class: 'btn-outline-success'},
            {key: 'overlay', name: 'Overlay', class: 'btn-outline-success'}, {key: 'autoresponder', name: 'Autoresponder', class: 'btn-outline-warning'},
            {key: 'opt_in', name: 'Opt-In', class: 'btn-outline-warning'}, {key: 'custom_text', name: 'Custom Text', class: 'btn-outline-info'},
        ],
        options_label: {
            preview: 'Preview', display: 'Display', content: 'Content', appearance: 'Appearance', button: 'Button', countdown: 'Countdown',
            overlay: 'Overlay', autoresponder: 'Autoresponder', opt_in: 'Opt-In', custom_text: 'Custom Text'
        },
        show_options: {},
        basic_model: {
            friendly_name: '',
            position: 'top_sticky',
            group_id: '0',
            headline: [{attributes: {}, insert: 'Your Headline'}],
            headline_color: '#ffffff',
            background_color: '#3BAF85',
            display: {
                show_bar_type: 'immediate', frequency: 'every', delay_in_seconds: 3, scroll_point_percent: 10
            },
            content: {
                sub_headline: [{attributes: {}, insert: ''}], sub_headline_color: '#ffffff', sub_background_color: '',
                video_type: 'none', content_youtube_url: '', content_vimeo_url: '', video_auto_play: 0, video_code: ''
            },
            appearance: {
                opacity: 100, drop_shadow: 0, close_button: 0, background_gradient: 0, gradient_end_color: '#3BAF85', gradient_angle: 0, powered_by_position: 'bottom_right',
            },
            button: {
                button_type: 'none', button_location: 'right', button_label: 'Click Here', button_background_color: '#515f7f', button_text_color: '#FFFFFF', button_animation: 'none',
                button_action: 'hide_bar', button_click_url: '', button_open_new: 0,
            },
            countdown: {
                countdown: 'none', countdown_location: 'left', countdown_format: 'dd', countdown_end_date: '0000-00-00', countdown_end_time: '00:00:00',
                countdown_timezone: 'Canada/Central', countdown_days: 0, countdown_hours: 0, countdown_minutes: 0, countdown_background_color: '', countdown_text_color: '#FFFFFF',
                countdown_on_expiry: 'hide_bar', countdown_expiration_text: 'Expired!', countdown_expiration_url: ''
            },
            overlay: {
                third_party_url: '', custom_link: 0, custom_link_text: '', meta_title: '', meta_description: '', meta_keywords: ''
            },
            autoresponder: {
                integration_type: 'none', list: '', after_submit: 'show_message', message: 'Thank You!', autohide_delay_seconds: 3, redirect_url: '',
            },
            opt_in: {
                opt_in_type: 'none', opt_in_youtube_url: '', opt_in_vimeo_url: '', opt_in_video_code: '', opt_in_video_auto_play: 0, image_url: '', image_upload: '',
                call_to_action: [{attributes: {}, insert: 'Call To Action Text Here'}], panel_color: '#F0F0F0',
                subscribe_text: [{attributes: {}, insert: 'Enter Your Name And Email Below...'}], subscribe_text_color: '#666666',
                opt_in_button_type: 'match_main_button', opt_in_button_label: 'Click Here', opt_in_button_bg_color: '#515f7f', opt_in_button_label_color: '#ffffff',
                opt_in_button_animation: 'none'
            },
            custom_text: {}
        },
        model: {},
        del_option: {key: '', label: ''},
        showUpload: false,
        uploadPercentage: 0
    }),
    created() {
        this.model = JSON.parse(JSON.stringify(this.basic_model));
        this.create_edit = (window._bar_opt_ary.create_edit || window._bar_opt_ary.create_edit === 'true');
        let vm = this;
        Object.keys(this.bar_option).forEach(function (item) {
            vm.bar_option[item] = !window._bar_opt_ary[item] ? false : (window._bar_opt_ary[item] === 'true')
        });
        
        Object.keys(this.model).forEach(function (item) {
            if (window._bar_opt_ary.model[item]) {
                vm.model[item] = window._bar_opt_ary.model[item];
            }
        });
    },
    mounted() {
        let vm = this;
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
        
        new PerfectScrollbar('.main-content', {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });
        
        this.initSelect2();
        this.initDatePicker();
        this.initQuillEditor();
        this.model.content.video_code = this.decodeHTML(this.model.content.video_code);
        $('[data-toggle="tags"]').each(function () {
            $(this).val(vm.model[$(this).data('parent')][$(this).attr('id')]);
            
            $(this).tagsinput({
                tagClass: 'badge badge-primary'
            });
            
            $(this).on('itemAdded', function () {
                vm.model[$(this).data('parent')][$(this).attr('id')] = $(this).val();
                vm.showSaveBtn($(this).data('parent'));
            });
            
            $(this).on('itemRemoved', function () {
                vm.model[$(this).data('parent')][$(this).attr('id')] = $(this).val();
                vm.showSaveBtn($(this).data('parent'));
            });
        });
    },
    methods: {
        initSelect2() {
            let $select = $('[data-toggle="select"]');
            let vm = this;
            if ($select.length) {
                // Init selects
                $select.each(function () {
                    $(this).select2({
                        minimumResultsForSearch: 12
                    }).on('select2:open', function () {
                        $('.form-control-label').css('color', '#525f7f');
                        $('label[data-id="' + $(this).attr('id') + '"]').css('color', '#515f7f');
                    }).on('select2:select', function () {
                        vm.changed_status = true;
                        if ($(this).data('parent')) {
                            vm.model[$(this).data('parent')][$(this).attr('id')] = $(this).val();
                            vm.showSaveBtn($(this).data('parent'));
                            if ($(this).attr('id') === 'integration_type') {
                                vm.getResponderList();
                            }
                        } else {
                            vm.model[$(this).attr('id')] = $(this).val();
                        }
                    }).on('select2:close', function () {
                        switch ($(this).attr('id')) {
                            case 'position':
                                vm.select2Open('#group_id');
                                break;
                            case 'group_id':
                                $('#headline').focus();
                                break;
                        }
                    });
                    if ($(this).data('parent')) {
                        $(this).val(`${vm.model[$(this).data('parent')][$(this).attr('id')]}`).trigger('change.select2');
                    } else {
                        $(this).val(`${vm.model[$(this).attr('id')]}`).trigger('change.select2');
                    }
                });
            }
        },
        select2Open(next_input) {
            $(next_input).select2('focus');
            $(next_input).select2('open');
        },
        changeDisableEnable(sel, parent, other_sel) {
            if ($(`#${sel}`).val().length > 0) {
                this.model[parent][other_sel] = [];
                $(`#${other_sel}`).attr('disabled', 'disabled');
            } else {
                $(`#${other_sel}`).removeAttr('disabled');
            }
        },
        initDatePicker() {
            let vm = this;
            let $datepicker = $('.datepicker');
            if ($datepicker.length) {
                $datepicker.each(function () {
                    let parent = $(this).data('parent');
                    $(this).datepicker({
                        disableTouchKeyboard: true,
                        autoclose: false,
                        startDate: new Date()
                    }).on('show', function () {
                        $('.datepicker.datepicker-dropdown').css('top', parseInt($('.datepicker.datepicker-dropdown').get(0).style.top) + 72 + 'px');
                    }).on('hide', function () {
                        if ($(this).val() !== '') {
                            if (parent) {
                                vm.model[parent][$(this).attr('id')] = $(this).val();
                            } else {
                                vm.model[$(this).attr('id')] = $(this).val();
                            }
                            vm.showSaveBtn('countdown');
                        } else {
                            if (parent) {
                                $(this).val(vm.model[parent][$(this).attr('id')]);
                            } else {
                                $(this).val(vm.model[$(this).attr('id')]);
                            }
                        }
                    }).on('changeDate', function () {
                        if ($(this).val() !== '') {
                            if (parent) {
                                vm.model[parent][$(this).attr('id')] = $(this).val();
                            } else {
                                vm.model[$(this).attr('id')] = $(this).val();
                            }
                            vm.showSaveBtn('countdown');
                        } else {
                            if (parent) {
                                $(this).val(vm.model[parent][$(this).attr('id')]);
                            } else {
                                $(this).val(vm.model[$(this).attr('id')]);
                            }
                        }
                    });
                    if (parent) {
                        $(this).val(vm.model[parent][$(this).attr('id')]);
                    } else {
                        $(this).val(vm.model[$(this).attr('id')]);
                    }
                });
            }
        },
        initQuillEditor() {
            let $quill = $('[data-toggle="quill"]');
            let vm = this;
            if ($quill.length) {
                $quill.each(function () {
                    let placeholder = $(this).data('quill-placeholder');
                    
                    // Init editor
                    let quill = new Quill($(this).get(0), {
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike']
                            ],
                            keyboard: {
                                bindings: {
                                    tab: false,
                                    handleEnter: {
                                        key: 13,
                                        handler: function () {
                                            return false;
                                        }
                                    }
                                }
                            }
                        },
                        placeholder: placeholder,
                        theme: 'snow'
                    });
                    
                    let parentId = '';
                    if ($(this).data('parent')) {
                        quill.setContents(vm.model[$(this).data('parent')][$(this).attr('id')]);
                        parentId = $(this).data('parent');
                    } else {
                        quill.setContents(vm.model[$(this).attr('id')]);
                    }
                    
                    let attrId = $(this).attr('id');
                    
                    let limit = 60;
                    quill.on('text-change', function (delta, old, source) {
                        vm.changed_status = true;
                        if (quill.getLength() > limit) {
                            quill.deleteText(limit, quill.getLength());
                        }
                        
                        if (parentId !== '') {
                            vm.model[parentId][attrId] = JSON.parse(JSON.stringify(quill.getContents().ops));
                            vm.showSaveBtn(parentId);
                        } else {
                            vm.model[attrId] = JSON.parse(JSON.stringify(quill.getContents().ops));
                        }
                    });
                });
            }
        },
        // Form Element Tab Key Press Event
        tabKeyPress(next_input, select, e) {
            if (e.keyCode === 9) {
                e.preventDefault();
                if (select) {
                    this.select2Open(next_input);
                } else {
                    $(next_input).focus().select();
                }
            } else {
                return true;
            }
        },
        updateJSColor(id, flag) {
            if (!flag) {
                if ($(`#${id}`).val() === '') {
                    this.model[id] = '';
                } else {
                    this.model[id] = this.rgbToHex($(`#${id}`).get(0).style['background-color']);
                }
            } else {
                if ($(`#${id}`).val() === '') {
                    this.model[flag][id] = '';
                } else {
                    this.model[flag][id] = this.rgbToHex($(`#${id}`).get(0).style['background-color']);
                }
                this.showSaveBtn(flag);
                this.changed_status = true;
            }
        },
        rgbToHex(rgbStr) {
            let a = rgbStr.split("(")[1].split(")")[0];
            a = a.split(",");
            let b = a.map(function (x) {
                x = parseInt(x).toString(16);
                return (x.length === 1) ? "0" + x : x;
            });
            
            return b.join("").toUpperCase();
        },
        // Option Hide Show Event
        toggleOption(name) {
            this.bar_option[name] = !this.bar_option[name];
            axios.post(`/hide-option/${window._bar_opt_ary.bar_id}`, {
                option_key: name
            }).then((r) => {
            }).catch((e) => {
            });
        },
        isUrlValid(userInput) {
            let res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
            return !(res === null);
        },
        clearOptionConfirm(key) {
            this.del_option.key = key;
            this.del_option.label = this.options_label[key];
            $('#delete-modal').modal('show');
        },
        clearOption() {
            this.model[this.del_option.key] = JSON.parse(JSON.stringify(this.basic_model[this.del_option.key]));
            axios.post(`/clear-option/${window._bar_opt_ary.bar_id}`, {
                option_key: this.del_option.key,
                data: this.model[this.del_option.key]
            }).then((r) => {
                if (r.data.status === 'success') {
                    this.commonNotification('success', 'Successfully cleared!');
                    $('#delete-modal').modal('hide');
                    this.show_btn[this.del_option.key] = false;
                    this.bar_option[this.del_option.key] = false;
                    let vm = this;
                    Object.keys(this.model[this.del_option.key]).forEach(function (item) {
                        if ($(`#${item}`).data('toggle')) {
                            if ($(`#${item}`).data('toggle') === 'select') {
                                $(`#${item}`).val(vm.model[vm.del_option.key][item]).trigger('change.select2');
                            }
                        }
                    });
                } else {
                    this.showClearErrorNotify();
                }
            }).catch((e) => {
                this.showClearErrorNotify();
            });
        },
        showSaveBtn(key) {
            this.changed_status = true;
            this.show_btn[key] = true;
        },
        saveOption(key) {
            let save_data = this.model[key];
            save_data.option_key = key;
            this.loading = true;
            axios.post(`/save-option/${window._bar_opt_ary.bar_id}`, save_data).then((r) => {
                this.loading = false;
                if (r.data.status === 'success') {
                    this.show_btn[key] = false;
                    $('.invalid-feedback').hide();
                    $('.form-control').removeClass('is-invalid');
                } else {
                    this.showSaveErrorNotify();
                }
            }).catch((e) => {
                this.loading = false;
                if (e.response.status === 422) {
                    let vm = this;
                    let notify_happened = false;
                    Object.keys(save_data).forEach(function (item) {
                        if (e.response.data[item]) {
                            vm.commonNotification('danger', e.response.data[item][0]);
                            notify_happened = true;
                        }
                    });
                    if (!notify_happened) {
                        this.showSaveErrorNotify();
                    }
                } else {
                    this.showSaveErrorNotify();
                }
            });
        },
        showGetErrorNotify() {
            this.commonNotification('danger', 'Failed! Please make sure your internet connection or contact to support.');
        },
        showSaveErrorNotify() {
            this.commonNotification('danger', 'Data save failed! Please make sure your internet connection or inserted data correctly.');
        },
        showClearErrorNotify() {
            this.commonNotification('danger', 'Data clear failed! Please make sure your internet connection.');
        },
        commonNotification(type, msg) {
            commonNotify('top', 'right', 'fas fa-bug', type, null, msg, '', 'animated fadeInDown', 'animated fadeOutUp');
        },
        decodeHTMLEntities(text) {
            let entities = [['amp', '&'], ['apos', '\''], ['#x27', '\''], ['#x2F', '/'], ['#39', '\''], ['#47', '/'], ['lt', '<'], ['gt', '>'], ['nbsp', ' '], ['quot', '"']];
            for (let i = 0, max = entities.length; i < max; ++i)
                text = text.replace(new RegExp('&' + entities[i][0] + ';', 'g'), entities[i][1]);
            return text;
        },
        decodeHTML(html) {
            let txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        },
        matchMainBar() {
            this.model.countdown.countdown_background_color = this.model.background_color;
            this.model.countdown.countdown_text_color = this.model.headline_color;
            $('#countdown_background_color').css('background-color', this.model.background_color.indexOf('#') > -1 ? this.model.background_color : `#${this.model.background_color}`);
            $('#countdown_background_color').val(this.model.background_color);
            $('#countdown_text_color').val(this.model.headline_color);
            $('#countdown_text_color').css('background-color', this.model.headline_color.indexOf('#') > -1 ? this.model.headline_color : `#${this.model.headline_color}`);
            this.show_btn.countdown = true;
        },
        countdownCalculate() {
            let vm = this;
            let date_val = new Date(vm.model.countdown.countdown_end_date);
            let change_date = new Date(date_val.toLocaleString('en-US', {
                timeZone: vm.model.countdown.countdown_timezone
            }));
            let curr_date = new Date();
            let date_diff = Math.abs(change_date.getTime() - curr_date.getTime());
            // parseInt(date_diff / (24 * 60 * 60 * 1000), 10)
            return (`0${Math.ceil(date_diff / (24 * 60 * 60 * 1000))}`).slice(-2);
        },
        validationCheck(flag, parent) {
            this.showSaveBtn(parent);
            switch (flag) {
                case 'button_label':
                    if (this.model[parent][flag] === '') {
                        this.commonNotification('danger', 'Button Text is required.');
                        this.model[parent][flag] = 'Click Here';
                        $(`#${flag}`).focus().select();
                    }
                    break;
                case 'countdown_expiration_url':
                    if (this.model[parent][flag] === '') {
                        this.commonNotification('danger', 'This field is required.');
                        $(`#${flag}`).focus().select();
                    }
                    break;
                default:
                    if (this.model[parent][flag] === '') {
                        this.commonNotification('danger', 'This field is required.');
                        $(`#${flag}`).focus().select();
                    }
                    break;
            }
        },
        changeVideoUrl(flag, parent) {
            this.showSaveBtn(parent);
            switch (this.model[parent][flag]) {
                case 'h':
                case 'ht':
                case 'htt':
                case 'http':
                case 'https':
                case 'https:':
                case 'https:/':
                case 'y':
                case 'yo':
                case 'you':
                case 'yout':
                case 'youtu':
                case 'youtub':
                case 'youtube':
                case 'v':
                case 'vi':
                case 'vim':
                case 'vime':
                case 'vimeo':
                case 'p':
                case 'pl':
                case 'pla':
                case 'play':
                case 'playe':
                case 'player':
                case 'player.':
                case '':
                case 'w':
                case 'ww':
                case 'www':
                case 'www.':
                    if (flag === 'content_youtube_url' || flag === 'opt_in_youtube_url') {
                        this.model[parent][flag] = `https://www.youtube.com/embed/`;
                    } else if (flag === 'content_vimeo_url' || flag === 'opt_in_vimeo_url') {
                        this.model[parent][flag] = `https://player.vimeo.com/video`;
                    } else {
                        this.model[parent][flag] = `http`;
                    }
                    break;
            }
            if (this.model[parent][flag] !== '') {
                if (this.model[parent][flag].indexOf('http') < 0) {
                    this.model[parent][flag] = `https://${this.model[parent][flag]}`;
                }
                if (flag === 'content_youtube_url' || flag === 'opt_in_youtube_url') {
                    if (this.model[parent][flag].indexOf('watch?v=') > -1) {
                        this.model[parent][flag] = this.model[parent][flag].replace('watch?v=', 'embed/');
                    }
                }
                if (flag === 'content_vimeo_url' || flag === 'opt_in_vimeo_url') {
                    if (this.model[parent][flag].indexOf('https://vimeo.com') > -1) {
                        this.model[parent][flag] = this.model[parent][flag].replace('https://vimeo.com', 'https://player.vimeo.com/video');
                    }
                }
            }
        },
        getResponderList() {
            this.model.auto_responder_list = [{key: '', name: '-- Choose List --'}];
            if (this.model.autoresponder.integration_type === 'none') {
                this.model.autoresponder.list = '';
            } else {
                this.loading = true;
                axios.get(`/get-responder-lists?responder_id=${this.model.autoresponder.integration_type}`).then((r) => {
                    this.loading = false;
                    if (r.data.result === 'success') {
                        this.model.auto_responder_list = JSON.parse(JSON.stringify(r.data.message));
                        this.model.autoresponder.list = '';
                    } else if (r.data.result === 'failure') {
                        this.model.autoresponder.list = '';
                        this.commonNotification('danger', r.data.message);
                    } else {
                        this.model.autoresponder.list = '';
                        this.showGetErrorNotify();
                    }
                }).catch((e) => {
                    this.loading = false;
                    this.model.autoresponder.list = '';
                    this.showGetErrorNotify();
                });
            }
        },
        uploadImage(e) {
            const file = e.target.files[0];
            const formData = new FormData();
            formData.enctype = 'multipart/form-data';
            formData.append('image-upload', file, file.name);
            this.uploadPercentage = 0;
            this.showUpload = true;
            axios.post(`/image-upload/${window._bar_opt_ary.bar_id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: function (progressEvent) {
                    this.uploadPercentage = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    if (this.uploadPercentage >= 100) {
                        this.showUpload = false;
                        this.loading = true;
                    }
                }.bind(this)
            }).then((r) => {
                this.loading = false;
                if (r.data.result === 'success') {
                    this.model.opt_in.image_upload = r.data.message;
                } else {
                    this.model.opt_in.image_upload = '';
                    this.commonNotification('danger', r.data.message);
                }
            }).catch((e) => {
                this.loading = false;
                this.model.opt_in.image_upload = '';
                this.commonNotification('danger', 'Internal Server Error');
            });
        }
    }
});
