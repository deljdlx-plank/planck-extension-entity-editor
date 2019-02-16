Planck.Extension.EntityEditor.View.Component.EntityListToolbar = function()
{

    this.$element = $(
        '<div class="plk-entity-list-toolbar">'+
            '<div class="plk-entity-list-toolbar-title"></div>'+
        '</div>'
    );

    this.$titleElement = this.$element.find('.plk-entity-list-toolbar-title');
    this.searchBar = new Planck.Extension.EntityEditor.View.Component.EntitySearchBar();

    this.$element.append(this.searchBar.getElement());

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
