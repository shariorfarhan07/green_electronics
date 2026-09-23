// Single place that decides how money is rendered. Always two decimals —
// line totals like 7.79 * 2 otherwise surface as 15.579999999999998, and
// whole amounts as "21.8" instead of "21.80".
export function money(value) {
    return Number(value || 0).toFixed(2);
}
