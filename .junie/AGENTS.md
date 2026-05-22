# Project Guidelines

1-Laravel 13
2-Livewire 4
3-FluxUI.dev https://fluxui.dev/
4-TailwindCSS
5-AlpineJS
6-PHP 8.4
7-All Text Must Translate in /lang/fa/price-today.php If you want to add new text add it in price-today.php.
8-Optimize Queries and use cache if you can.
9-Try to use AlpineJS for UI and Livewire for Backend.
10-We have to use modal for create and edit form.
11-We have to use pagination for list.
12-Use Blade for view and Livewire for component.
13-Use TailwindCSS for styling.
14-for better validation use livewire form https://livewire.laravel.com/docs/4.x/forms.
15-For icons use lucide icons https://lucide.dev/icons. and you can add icon by `php artisan flux:icon icon-name`.
16-For models eloquent use https://laravel.com/docs/13.x/eloquent and add relations.
17-for permissions use https://spatie.be/docs/laravel-permission/v6/introduction and we add all permissions in /lang/fa/permissions.php and /lang/en/permissions.php.
18-In livewire 4 there is no Volt and Livewire\Component is good.
19-Use https://livewire.laravel.com/docs/4.x/attribute-computed for computed properties and load data by that.
20-Use For all modal <flux:modal flyout position="right"> not normal modal.
21-Use https://fluxui.dev/components/select#backend-search for select when database options.
21-for event use full name of event assign-data name is not good use panels.administrator.learning-management.school.edit.assign-data
22-When you want to load livewire component user <livewire:component-name :key="$componentId" />
23-<flux:main> is container for all pages.
24-After all livewire action we need Flux::toast('message');
25-for actions use buttons with icon and tooltip.
<flux:tooltip content="{{ __('price-today.import') }}">
<flux:button size="xs" variant="primary" color="teal" icon="upload" icon:variant="outline" wire:click="$dispatch('learning-management.student.import.assign-data', { classId: {{ $class->id }} })" />
</flux:tooltip>

                            <flux:tooltip content="{{ __('price-today.delete') }}">
                                <flux:button size="xs" variant="primary" color="red" icon="trash" icon:variant="outline" wire:click="delete({{ $class->id }})" wire:confirm="{{ __('price-today.are_you_sure') }}" />
                            </flux:tooltip>
26-All Date must be use Jalali Date. morilog/jalali
27-Use https://github.com/morilog/jalali for date.
28-For Table use https://fluxui.dev/components/table and add search in searchable fields top of <flux:table.columns>
29-For Search and Fillter create use card and use <flux:card> and data of table use <flux:table.columns>
30-https://fluxui.dev/components/pillbox#searchable use it for search.
31-Use https://github.com/morilog/jalali for date.
32-searchable for all select and search <flux:select searchable>
33-Buttons use <flux:button> they have many colors base on action user can use. For example <flux:button color="orange">Save</flux:button> for save action.
<flux:button variant="primary" color="zinc">Zinc</flux:button>
<flux:button variant="primary" color="red">Red</flux:button>
<flux:button variant="primary" color="orange">Orange</flux:button>
<flux:button variant="primary" color="amber">Amber</flux:button>
<flux:button variant="primary" color="yellow">Yellow</flux:button>
<flux:button variant="primary" color="lime">Lime</flux:button>
<flux:button variant="primary" color="green">Green</flux:button>
<flux:button variant="primary" color="emerald">Emerald</flux:button>
<flux:button variant="primary" color="teal">Teal</flux:button>
<flux:button variant="primary" color="cyan">Cyan</flux:button>
<flux:button variant="primary" color="sky">Sky</flux:button>
<flux:button variant="primary" color="blue">Blue</flux:button>
<flux:button variant="primary" color="indigo">Indigo</flux:button>
<flux:button variant="primary" color="violet">Violet</flux:button>
<flux:button variant="primary" color="purple">Purple</flux:button>
<flux:button variant="primary" color="fuchsia">Fuchsia</flux:button>
<flux:button variant="primary" color="pink">Pink</flux:button>
<flux:button variant="primary" color="rose">Rose</flux:button>
33-In forms and modals only user w-full buttons and only save
34-try to use colors
35-I want to use signle file livewire component
36-I use pages:: for livewire page.
37-If possible, change class base to single file compoenet.
