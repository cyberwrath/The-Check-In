import Velocity from "velocity-animate";

(function (cash) {
    "use strict";

    // Close active accordion
    cash("body").on("click", ".btn-close", function () {
        Velocity(cash(this).closest(".alert"), "fadeOut", {
            duration: 300,
            complete: function (el) {
                cash(el).removeClass("show");
            },
        });
    });
})(cash);
