$(document).ready(function () {
    var oldContainer;
    var sortableList = $("ol.nested_with_switch").sortable({
        group: 'nested',
        afterMove: function (placeholder, container) {
            if (oldContainer != container) {
                if (oldContainer)
                    oldContainer.el.removeClass("active");
                container.el.addClass("active");
                oldContainer = container;
            }
        },
        onDrop: function (item, container, _super) {
            container.el.removeClass("active");
            _super(item);
        },
        serialize: function (parent, children, isContainer) {

            if (isContainer) {
                return children;
            }

            parent.children = children;
            var retour = {};
            retour.id = parent.attr("id");
            retour.children = children;
            return retour;
        }
    })

    $("#savecategories").on("click", function (event) {
        event.preventDefault();
        var result = $(sortableList.sortable("serialize"));
        var trueResult = new Array();
        for (var i = 0; i < result.length; i++) {
            trueResult.push(result[i]);
        }
        $.ajax({
            type: "POST",
            url: Routing.generate("gg_team_forum_admin_savecategories"),
            data: {data: trueResult},
            dataType: "json"
        }).done(function () {
            $(".alert-success").removeClass("hidden");
            $(".alert-success").text("Enregitré avec Succès");
            setTimeout(function () {
                $(".alert-success").addClass("hidden");
                $(".alert-success").text("");
            }, 5000);
        }).fail(function () {
            $(".alert-danger").removeClass("hidden");
            $(".alert-danger").text("Un problème a eu lieu lors de l'enregistrement.");
            setTimeout(function () {
                $(".alert-danger").addClass("hidden");
                $(".alert-danger").text("");
            }, 5000);
        });
    });
});
