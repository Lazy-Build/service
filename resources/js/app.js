import './bootstrap';
import Alpine from 'alpinejs';

Alpine.directive('json', (el, { value, modifiers, expression}, {Alpine: instance, effect, evaluate}) => {
    effect(() => {
        el.textContent = JSON.stringify(evaluate(expression), null, 2);
    })
})
window.Alpine = Alpine;

Alpine.start();
