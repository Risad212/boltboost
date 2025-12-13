
document.addEventListener('DOMContentLoaded', function () {
  const tabs = document.querySelectorAll('.ba-dashboard__tab__item');
  const panels = document.querySelectorAll('.ba-dashboard__tab__panel');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const target = tab.dataset.tab;

      tabs.forEach(t => t.classList.remove('active'));
      panels.forEach(p => p.classList.remove('active'));

      tab.classList.add('active');
      document.getElementById(target).classList.add('active');
    });
  });
});

