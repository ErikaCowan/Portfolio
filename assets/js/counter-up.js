// assets/js/counter-up.js
// Counts each .count up to its data-count value once the stats scroll into view.
// Optional data-suffix sets the ending character (defaults to "+").
document.addEventListener('DOMContentLoaded', function() {
  const countingSection = document.querySelector('.counting');
  if (!countingSection) return;
  const counters = countingSection.querySelectorAll('.count');
  let hasStarted = false;

  const runCount = () => {
    counters.forEach($this => {
      const countTo = +$this.getAttribute('data-count');
      const suffix  = $this.hasAttribute('data-suffix') ? $this.getAttribute('data-suffix') : '+';
      $({ countNum: 0 }).animate(
        { countNum: countTo },
        {
          duration: 2500,
          step(now) {
            $this.textContent = Math.floor(now).toLocaleString();
          },
          complete() {
            $this.textContent = countTo.toLocaleString() + suffix;
          }
        }
      );
    });
  };

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !hasStarted) {
          runCount();
          hasStarted = true;
          obs.unobserve(countingSection);
        }
      });
    },
    { threshold: 0.3 }
  );

  observer.observe(countingSection);
});
