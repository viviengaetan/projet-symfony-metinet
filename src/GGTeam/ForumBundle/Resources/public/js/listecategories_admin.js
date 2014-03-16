
var sortableList;
var activeButton;
$(document).ready(function () {
    var oldContainer;
    sortableList = $("ol.nested_with_switch").sortable({
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
        desactiveButton();
        saveCategories();
    });

    $("#button-remove").on("click", function(event) {
        event.preventDefault();
        saveCategories(deleteCategory);
    });
    $(".category-button").on("dblclick", function(event) {
        event.preventDefault();
        window.location = $(this).parent().attr("href");
    });

    $(".category-button").on("click", function(event) {
        event.preventDefault();

        $(this).toggleClass("active");

        if($(this).hasClass("active")) {
            desactiveButton();
            $(this).addClass("active");
            activeButton = $(this);
            $("#button-fiche").attr("disabled", false);
            $("#button-fiche").attr("href", $(this).parent().attr("href"));

            if($(this).parent().parent().children("ol").children().length == 0) {
                $("#button-remove").attr("disabled", false);
                var id = $(this).attr("info");
                $("#button-remove").attr("href", Routing.generate("gg_team_forum_admin_removecategory", {idcategory:id}));
            } else {
                $("#button-remove").attr("disabled", "disabled");
            }
        } else {
            desactiveButton();

            $("#button-remove").attr("disabled", "disabled");
            $("#button-fiche").attr("disabled", "disabled");
        }
    });
});

function saveCategories(callback) {
    var result = $(sortableList).sortable("serialize");
    var trueResult = new Array();
    for (var i = 0; i < result.length; i++) {
        trueResult.push(result[i]);
    }
    $.ajax({
        type: "POST",
        url: Routing.generate("gg_team_forum_admin_savecategories"),
        data: {data: trueResult},
        dataType: "json"
    }).done(function (data) {
        if(data.success == 1) {
            messageAlert(data.msg, "success");
        } else {
            messageAlert(data.msg, "danger");
        }
        if(typeof callback == "function") {
            callback($("#button-remove"));
        }
    }).fail(function () {
        messageAlert("Un problème a eu lieu lors de l'enregistrement.", "danger");
    });
}

function deleteCategory(object) {
    $.ajax({
        type: "POST",
        url: $(object).attr("href"),
        dataType: "json"
    }).done(function(data) {
        activeButton.parent().parent().remove();
        desactiveButton();
        if(data.success == 1) {
            messageAlert(data.msg, "success");
        } else {
            messageAlert(data.msg, "danger");
        }
    }).fail(function() {
        messageAlert("Un problème a eu lieu lors de l'enregistrement.", "danger");
    });
}

function desactiveButton() {
    $("ol.nested_with_switch div.btn").removeClass("active");
    $("#button-remove").attr("disabled", "disabled");
    $("#button-fiche").attr("disabled", "disabled");
}
