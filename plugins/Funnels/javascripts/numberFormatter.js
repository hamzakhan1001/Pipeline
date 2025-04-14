function formatNumber(value) {
  if (!value) {
    return '0';
  }
  return value.toLocaleString();
}
function formatAbbr(value) {
  if (!value) {
    return '0';
  }
  if (value >= 99950000) { // For hundreds of millions
    return `${Math.round(value / 1000000)}m`;
  }
  if (value >= 999500) { // For millions
    return `${(Math.round(value / 100000) / 10).toFixed(1)}m`;
  }
  if (value >= 99950) { // For hundreds of thousands
    return `${Math.round(value / 1000)}k`;
  }
  if (value >= 1000) { // For thousands
    return `${(Math.round(value / 100) / 10).toFixed(1)}k`;
  }
  return value.toString();
}
module.exports = {
  formatNumber,
  formatAbbr,
};
