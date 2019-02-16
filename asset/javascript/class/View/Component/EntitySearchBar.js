Planck.Extension.EntityEditor.View.Component.EntitySearchBar = function(container)
{

    this.$element = $('<div class="plk-entity-search-bar plk-input-container plk-icon" data-behaviour="interactive" data-icon="&#xf002;"></div>');
    this.$input = $('<input class="plk-entity-search-bar-input" />');

    this.$element.append(this.$input);

};



Planck.Extension.EntityEditor.View.Component.EntitySearchBar.prototype.getElement = function()
{
    return this.$element;
};