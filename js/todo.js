/**
 * Created by jlou on 8/8/16.
 */

var BaseView = tungsten.View,
    BaseModel = tungsten.Model,
    BaseCollection = tungsten.Collection;
var ENTER_KEY = 13;
var ESC_KEY = 27;

// each to-do item
var TodoItemView = BaseView.extend({
    events: {
        'blur .js-todo-edit': 'handleBlurTodoEdit',
        'click .js-toggle': 'handleChangeToggle',
        'click .js-destroy': 'handleClickDestroy',
        'dblclick .js-todo-title': 'handleDblClickTodoTitle',
        'keydown .js-todo-edit': 'handleKeyDownTodoEdit',
        'keypress .js-todo-edit': 'handleKeyPressTodoEdit'
    },
    handleBlurTodoEdit: function (e) {
        if (!this.model.get('editing')) {
            return;
        }
        this.clear(e.currentTarget);
    },
    handleClickDestroy: function () {
        this.model.destroy();
    },
    handleChangeToggle: function () {
        this.model.set('completed', !this.model.get('completed'));
    },
    handleDblClickTodoTitle: function (e) {
        this.model.set('editing', true);
        this.listenToOnce(this, 'rendered', function () {
            this.el.querySelector('.js-todo-edit').focus();
        });
        e.currentTarget.focus();
    },
    handleKeyDownTodoEdit: function (e) {
        if (e.which === ESC_KEY) {
            this.model.set('editing', false);
            this.model.set('title', this.model.get('title'));
        }
    },
    handleKeyPressTodoEdit: function (e) {
        if (e.which === ENTER_KEY) {
            this.clear(e.currentTarget);
        }
    },
    clear: function (input) {
        var value = input.value;

        var trimmedValue = value.trim();

        if (trimmedValue) {
            this.model.set({title: trimmedValue});
            this.model.set('editing', false);
        } else {
            this.handleClickDestroy();
        }
    }
}, {
    debugName: 'TodoItemView'
});

// a new item
var NewTodoItemView = BaseView.extend({
    events: {
        'keyup': 'handleKeyup'
    },
    handleKeyup: function (e) {
        if (e.which === ENTER_KEY && e.currentTarget.value !== '') {
            // add a new item to the collection
            this.model.get('todoItems').add({title: e.currentTarget.value.trim()});
            this.model.set('newValue', '');
        } else {
            this.model.set('newValue', e.currentTarget.value);
        }
    }
}, {
    debugName: 'NewTodoItemView'
});

// contains two child views
var TodoAppView = BaseView.extend({
    // include two child view here
    childViews: {
        'js-new-todo': NewTodoItemView,
        'js-todo-item': TodoItemView
    },
    events: {
        'click .js-toggle-all': 'handleChangeToggleAll',
        'click .js-clear-completed': 'handleClickClearCompleted'
    },
    handleClickClearCompleted: function () {
        _.invoke(this.model.get('todoItems').where({completed: true}), 'destroy');
        return false;
    },
    handleChangeToggleAll: function (e) {
        var completed = e.currentTarget.checked;
        this.model.get('todoItems').each(function (item) {
            item.set('completed', completed);
        });
    }
}, {
    debugName: 'TodoAppView'
});

// TODO: What is the exact meaning of this part?
var TodoItemCollection = BaseCollection.extend({
    model: BaseModel.extend(
        {},
        {debugName: 'TodoItemModel'}
    )
});

var TodoAppModel = BaseModel.extend({

    // declare todoItems as a collection
    relations: {
        todoItems: TodoItemCollection
    },

    defaults: {
        // init an empty array
        todoItems: [],
    },

    derived: {
        // key is the derived property
        hasTodos: {
            // an array contains the derived property that relies on
            deps: ['todoItems'],
            fn: function () {
                return this.get('todoItems').length > 0;
            }
        },

        incompletedItems: {
            deps: ['todoItems'],
            fn: function () {
                return this.get('todoItems').filter(function (item) {
                    return !item.get('completed');
                });
            }
        },

        allCompleted: {
            deps: ['todoItems'],
            fn: function () {
                if (this.get('todoItems').length) {
                    return this.get('todoItems').every(function (item) {
                        return item.get('completed');
                    });
                }
            }
        },

        todoCount: {
            deps: ['incompletedItems'],
            fn: function () {
                return this.get('incompletedItems').length;
            }
        },

        todoCountPlural: {
            deps: ['todoCount'],
            fn: function () {
                return this.get('todoCount') !== 1;
            }
        },

        hasCompleted: {
            deps: ['todoItems'],
            fn: function () {
                return this.get('todoItems').length - this.get('incompletedItems').length > 0;
            }
        }
    }
});

new TodoAppView({
    el: document.querySelector('#app'),
    template: compiledTemplates.app_view,
    model: new TodoAppModel({}),
    dynamicInitialize: true
});