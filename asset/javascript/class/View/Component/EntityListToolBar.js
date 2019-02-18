Planck.Extension.EntityEditor.View.Component.EntityListToolbar = function(entityList)
{

    this.entityList = entityList;

    this.$element = $(
        '<div class="plk-entity-list-toolbar">'+
            '<div class="plk-entity-list-toolbar-title"></div>'+
        '</div>'
    );

    this.$titleElement = this.$element.find('.plk-entity-list-toolbar-title');

    this.searchBar = new Planck.Extension.EntityEditor.View.Component.EntitySearchBar(
        this.entityList.getEntityType()
    );

    this.searchBar.on('search', function(result) {
        this.events.search(result);
    }.bind(this));


    this.$element.append(this.searchBar.getElement());

    this.events = {
        search: function(result) {

        }
    };
};

Planck.Extension.EntityEditor.View.Component.EntityListToolbar.prototype.getSearch = function()
{
   return this.searchBar.getSearch();
};

Planck.Extension.EntityEditor.View.Component.EntityListToolbar.prototype.on = function(eventName, callback)
{
   this.events[eventName] = callback;
   return this;
};



Planck.Extension.EntityEditor.View.Component.EntityListToolbar.prototype.setTitle = function(title)
{
    this.$titleElement.html(title);
    return this;
};

Planck.Extension.EntityEditor.View.Component.EntityListToolbar.prototype.getElement = function()
{
   return this.$element;
};
