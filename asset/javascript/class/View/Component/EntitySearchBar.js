Planck.Extension.EntityEditor.View.Component.EntitySearchBar = function(entityType)
{

    this.entityType = entityType;


    this.$element = $('<div class="plk-entity-search-bar plk-input-container plk-icon" data-behaviour="interactive" data-icon="&#xf002;"></div>');
    this.$input = $('<input class="plk-entity-search-bar-input" />');

    this.$element.append(this.$input);


    this.$input.keyup(function(event) {
        var search = this.getSearch();
        this.search(search);
    }.bind(this));

    this.services = {
        search: {
            url: '?/@extension/planck-extension-entity_editor/entity/api[search]'
        }
    };

    this.events = {
        search: function(result) {
        }
    };

};

Planck.Extension.EntityEditor.View.Component.EntitySearchBar.prototype.getSearch = function()
{
   return this.$input.val();
};
Planck.Extension.EntityEditor.View.Component.EntitySearchBar.prototype.on = function(eventName, callback)
{
    this.events[eventName] = callback;
    return this;
};



Planck.Extension.EntityEditor.View.Component.EntitySearchBar.prototype.search = function(search)
{
   var url = this.services.search.url;
   var data = {
       entityType: this.entityType,
       search: search,
       limit: 2
   };
   Planck.ajax({
       url: url,
       method: 'get',
       data: data,
       success: function(response) {
           this.events.search(response);
       }.bind(this)
   });


};



Planck.Extension.EntityEditor.View.Component.EntitySearchBar.prototype.getElement = function()
{
    return this.$element;
};