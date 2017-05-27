/**
 * Created by wangtao on 2017/5/27.
 */
var growl = {
    options: {
        icon: 'glyphicon glyphicon-ok-sign',
        settings: {
            type: "success",
            showProgressbar: true,
            placement: {
                from: "top",
                align: "center"
            },
            offset: 0,
            spacing: 10,
            z_index: 1031,
            delay: 3000,
            timer: 1000,
            template: ""
        }
    },
    success: function (message) {
        this._notify(message);
    },
    info: function (message) {
        this.options.icon = "glyphicon glyphicon-info-sign";
        this.options.settings.type = "info";
        this._notify(message);
    },
    danger: function (message) {
        this.options.icon = "glyphicon glyphicon-remove-sign";
        this.options.settings.type = "danger";
        this._notify(message);
    },
    warning: function (message) {
        this.options.icon = "glyphicon glyphicon-exclamation-sign";
        this.options.settings.type = "warning";
        this._notify(message);
    },
    _notify: function (message) {
        this.options.settings.template = '<div data-notify="container" class="col-xs-11 col-sm-2 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress kv-progress-bar" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '</div>';

        $.notify({
            icon: this.options.icon,
            message: message

        }, this.options.settings);
    }
};