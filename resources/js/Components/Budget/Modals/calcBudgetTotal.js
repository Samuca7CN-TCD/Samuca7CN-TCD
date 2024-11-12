export default function calcBudgetTotal(form) {
    let total = 2900;
    let buffet = 59;
    let option = {
        bar: 15 * form.guests_quantity,
        dj: 1200,
        decoration: form.decoration_id == 1 ? 1400 : 0,
        advisory: 900,

        additional_meat: 7 * form.guests_quantity,
        ravioli: 5 * form.guests_quantity,
        additional_drinks: 5 * form.guests_quantity,
        other_beers: 5 * form.guests_quantity,
    }

    if (form.buffet_id == 1) buffet += 20;
    if (form.beer) buffet += 15;
    const buffet_aux = buffet;

    if (form.decoration_id != 1 || !form.bar) {
        total = 1.1 * total;
        buffet = 1.1 * buffet;
        option.decoration = 1.1 * option.decoration;
        option.bar = 1.1 * option.bar;
    }

    if (form.guests_quantity < 100) {
        total += 0.1 * 2900;
        buffet += 0.1 * buffet_aux;
        option.decoration += 0.1 * 1400;
        option.bar += 0.1 * (15 * form.guests_quantity);
    }

    total += buffet * form.guests_quantity;
    total += option.decoration;

    if (form.bar) total += option.bar;
    if (form.dj) total += option.dj;
    if (form.advisory) total += option.advisory;

    if (form.buffet_id == 1 && form.additional_meat) total += option.additional_meat;
    if (form.ravioli) total += option.ravioli;
    if (form.bar && form.additional_drinks) total += option.additional_drinks;
    if (form.beer && form.other_beers) total += option.other_beers;

    return total;
}