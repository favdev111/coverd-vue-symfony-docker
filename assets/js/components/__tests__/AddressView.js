import { shallowMount } from '@vue/test-utils'
import Component from '../AddressView'

let wrapper;
const mountComponent = (value, hasTitle) => {
    wrapper = shallowMount(Component,  {
        propsData: {
            value: value || undefined,
            hasTitle: hasTitle || false,
        }
    });
};

afterEach(() => {
    wrapper.destroy();
});

describe('AddressView', () => {
    test('is empty when value prop is undefined', () => {
        mountComponent();
        expect(wrapper.isEmpty()).toBeTruthy();
        expect(wrapper.element).toMatchSnapshot();
    });
    test('container is empty when value prop is empty', () => {
        mountComponent({});
        expect(wrapper.is('.addressform')).toBeTruthy();
        expect(wrapper.contains('div > div')).toBeFalsy();
        expect(wrapper.element).toMatchSnapshot();
    });
    test('shows title when hasTitle is true', () => {
        mountComponent(
            {
                title: 'My Title',
            },
            true
        );

        const text = wrapper.text();
        expect(text).toContain('My Title');
        expect(wrapper.element).toMatchSnapshot();
    });
    test('doesn\'t show title when hasTitle is false', () => {
        mountComponent(
            {
                title: 'My Title',
            },
            false
        );

        const text = wrapper.text();
        expect(text).not.toContain('My Title');
        expect(wrapper.element).toMatchSnapshot();
    });
    test('shows full address', () => {
        mountComponent({
            street1: '123 Main Ave',
            street2: 'Suite 321',
            city: 'Miami',
            state: 'Florida',
            postalCode: '12345',
            country: 'United States'
        });

        const text = wrapper.text();
        expect(text).toContain('123 Main Ave');
        expect(text).toContain('Suite 321');
        expect(text).toContain('Miami,');
        expect(text).toContain('Florida');
        expect(text).toContain('12345');
        expect(text).toContain('United States');
        expect(wrapper.element).toMatchSnapshot();
    });
    const partialData = [
        [{city: 'Miami'}, 'Miami,'],
        [{state: 'Florida'}, 'Florida'],
        [{postalCode: '12345'}, '12345'],
    ];
    test.each(partialData)('shows partial city, state, and postal code line', (propValue, expected) => {
        mountComponent(propValue);
        const cityStatePostalCode = wrapper.findAll('[data-testid="city-state-postalcode"] > span');
        expect(cityStatePostalCode.length).toEqual(1);
        expect(wrapper.text()).toContain(expected);
        expect(wrapper.element).toMatchSnapshot();
    })
});
