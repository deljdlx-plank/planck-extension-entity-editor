Planck.Extension.EntityEditor.View.Component.EntityList = function(container)
{
   this.$container = $(container);
   this.$list = this.$container.find('.plk-entity-list');
   this.$pagination = this.$container.find('.plk-pagination');

   this.entityName = this.$container.attr('data-entity-type');


   this.currentSegmentIndex = 0;

   this.segmentSize = 2;

   //this.loadEditor();

    this.events = {
        itemClick : function(entityDescriptor) {
            console.log(entityDescriptor);
        },
        itemLoad: function() {

        }
    };
};


Planck.Extension.EntityEditor.View.Component.EntityList.prototype.on = function(event, callback)
{
    this.events[event] = callback;
    return this;
};



Planck.Extension.EntityEditor.View.Component.EntityList.prototype.load = function(segmentIndex)
{

    if(!isset(segmentIndex)) {
        segmentIndex = 0;
    }

      var url = '?/@extension/planck-extension-entity_editor/entity/api[list]';

      var data = {
          entity: this.entityName,
          limit: this.segmentSize,
          offset: (segmentIndex*this.segmentSize)
      };
      Planck.ajax({
          url: url,
          method: 'get',
          data: data,
          success: function(descriptor) {

              this.clearList();
                $(descriptor.entities).each(function(index, entity) {
                    this.renderRecord(entity);
                }.bind(this));


              this.currentSegmentIndex = descriptor.metadata.segment.currentIndex;

                this.renderPagination(descriptor.metadata.segment);

          }.bind(this)
      });
};


Planck.Extension.EntityEditor.View.Component.EntityList.prototype.renderRecord = function(entity)
{

    var $tr = $('<tr></tr>');
    $tr.attr('data-entity', JSON.stringify(entity));


    for(var attributeName in entity) {
        var value = entity[attributeName];
        $tr.append('<td>'+value+'</td>');
    }

    $tr.click(function(event) {

        var $element = $(event.target).parents('tr');
        var entity = JSON.parse($element.attr('data-entity'));

        var data = {
            type: this.entityName,
            entity: entity,
        };

        this.events.itemClick(data, $element, event);
    }.bind(this));

    this.$list.append($tr);
};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.renderPagination = function(segmentDescriptor)
{
    this.$pagination.html('');


    if(this.currentSegmentIndex>0) {
        this.$pagination.append('<a class=""><i class="fas fa-angle-left"></i></a>')
    }


    for(var pageIndex = 0 ; pageIndex<segmentDescriptor.count; pageIndex++) {
        var pageNumber = pageIndex + 1;

        if(pageIndex == segmentDescriptor.currentIndex) {
            this.$pagination.append('<span class="selected">'+pageNumber+'</i></span>')

        }
        else {
            var $paginationItem = $('<a data-segment-index="'+pageIndex+'">'+pageNumber+'</i></a>');

            $paginationItem.click(function(event) {
               var segmentIndex = $(event.target).attr('data-segment-index');
               this.load(segmentIndex);
            }.bind(this));

            this.$pagination.append($paginationItem)

        }

    }

    if(this.currentSegmentIndex<segmentDescriptor.count-1) {
        this.$pagination.append('<a class=""><i class="fas fa-angle-right"></i></a>')
    }



};

Planck.Extension.EntityEditor.View.Component.EntityList.prototype.clearList = function()
{
   this.$list.find('tbody').html('');
};