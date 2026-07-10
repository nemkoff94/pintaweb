// Simple intersection observer to add in-view animations
document.addEventListener('DOMContentLoaded', function(){
  const obs = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        e.target.classList.add('in-view');
        obs.unobserve(e.target);
      }
    })
  }, {threshold:0.12});
  document.querySelectorAll('[data-anim]').forEach(el=>{ el.classList.add('fade-up'); obs.observe(el); });

  // Simple counters
  const counters = document.querySelectorAll('[data-count]');
  counters.forEach(node=>{
    const end = parseInt(node.getAttribute('data-count'),10)||0;
    let cur=0; const dur=1200; const stepTime=Math.max(8,Math.floor(dur/end||20));
    const timer=setInterval(()=>{ cur+=Math.ceil(end/ (dur/stepTime)); node.textContent=cur; if(cur>=end){ node.textContent=end; clearInterval(timer); } }, stepTime);
  });
});
