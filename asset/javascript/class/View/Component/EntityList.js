Planck.Extension.EntityEditor.View.Component.EntityList = function (container) {
    this.$container = $(container);
    this.$list = this.$container.find('.plk-entity-list');
    this.$pagination = this.$container.find('.plk-pagination');

    this.entityType = this.$container.attr('data-entity-type');
    this.entityLabel = this.$container.attr('data-entity-label');


    this.currentSegmentIndex = 0;

    this.segmentSize = 2;


    this.toolbar = null;
    this.decorateContainer();


    this.services = {
        getEntities: {
            url: '?/@extension/planck-extension-entity_editor/entity/api[search]'
        }
    };

    this.events = {
        itemClick: function (entityDescriptor) {
            console.log(entityDescriptor);
        },
        itemLoad: function () {

        }
    };

    this.search = '';


};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.getEntityType = function () {
    return this.entityType;
};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.decorateContainer = function ()
{

    this.toolbar = new Planck.Extension.EntityEditor.View.Component.EntityListToolbar(this);

    this.toolbar.setTitle(this.entityLabel);

    this.toolbar.on('search', function (result) {

        console.log(this.toolbar);

        this.search = this.toolbar.getSearch();
        this.renderResultSet(result);
    }.bind(this));


    var $header = $('<div class="plk-header"></div>');
    $header.append(this.toolbar.getElement());

    this.$header = $header;

    this.$container.prepend(
        $header
    );
};


Planck.Extension.EntityEditor.View.Component.EntityList.prototype.on = function (event, callback) {
    this.events[event] = callback;
    return this;
};


Planck.Extension.EntityEditor.View.Component.EntityList.prototype.load = function (segmentIndex) {

    if (!isset(segmentIndex)) {
        segmentIndex = 0;
    }

    var url = this.services.getEntities.url;

    var data = {
        entityType: this.entityType,
        search: this.search,
        limit: this.segmentSize,
        offset: (segmentIndex * this.segmentSize)
    };
    Planck.ajax({
        url: url,
        method: 'get',
        data: data,
        success: function (result) {

            this.renderResultSet(result);

        }.bind(this)
    });
};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.renderResultSet = function (result) {

    var segment = new Planck.Model.Segment(result);

    this.clearList();



    $(segment.getEntities()).each(function (index, entity) {
        this.renderRecord(entity);
    }.bind(this));

    this.currentSegmentIndex = result.metadata.segment.currentIndex;

    //console.log(result.metadata.segment)

    this.renderPagination(result.metadata.segment);

};


/**
 *
 * @param {Planck.Model.Entity} entityInstance
 */
Planck.Extension.EntityEditor.View.Component.EntityList.prototype.renderRecord = function (entityInstance) {


    var $tr = $('<tr></tr>');
    $tr.data('entity', entityInstance);


    $tr.attr('data-entity', entityInstance.toJSON());


    for (var attributeName in entityInstance.getValues()) {
        var value = entityInstance.getValue(attributeName);

        if(this.search) {
            var value = this.searchAndHighlight(value, this.search);
        }

        $tr.append('<td>' + value + '</td>');
    }

    //==================================================
    $tr.click(function (event) {

        var $element = $(event.target).parents('tr');


        var entity = $(event.target).parents('tr').data('entity');


        var data = {
            type: this.entityType,
            entity: entity,
        };

        this.events.itemClick(data, $element, event);
    }.bind(this));
    !//==================================================

        this.$list.append($tr);
};




Planck.Extension.EntityEditor.View.Component.EntityList.prototype.renderPagination = function (segmentDescriptor) {
    this.$pagination.html('');


    if (this.currentSegmentIndex > 0) {
        this.$pagination.append('<a class="" data-behaviour="interactive"><i class="fas fa-angle-left"></i></a>')
    }


    for (var pageIndex = 0; pageIndex < segmentDescriptor.count; pageIndex++) {
        var pageNumber = pageIndex + 1;

        if (pageIndex == segmentDescriptor.currentIndex) {
            this.$pagination.append('<span class="selected" data-behaviour="interactive">' + pageNumber + '</i></span>')

        }
        else {
            var $paginationItem = $('<a data-segment-index="' + pageIndex + '" data-behaviour="interactive">' + pageNumber + '</i></a>');

            $paginationItem.click(function (event) {
                var segmentIndex = $(event.target).attr('data-segment-index');
                this.load(segmentIndex);
            }.bind(this));

            this.$pagination.append($paginationItem)

        }

    }

    if (this.currentSegmentIndex < segmentDescriptor.count - 1) {
        this.$pagination.append('<a class="" data-behaviour="interactive"><i class="fas fa-angle-right"></i></a>')
    }


};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.searchAndHighlight = function(value, search)
{
    var regexp = new RegExp('('+search+')','gi');
    return value.replace(regexp, this.highlight('$1'));
};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.highlight = function(string)
{
    return '<span class="plk-highlighted">'+string+'</span>';
};



Planck.Extension.EntityEditor.View.Component.EntityList.prototype.clearList = function () {
    this.$list.find('tbody').html('');
};