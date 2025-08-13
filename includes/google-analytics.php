<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  // Replace G-XXXXXXXXXX with your actual Google Analytics 4 Measurement ID
  gtag('config', 'G-XXXXXXXXXX', {
    page_title: document.title,
    page_location: window.location.href,
    send_page_view: true
  });
  
  // Enhanced ecommerce tracking
  gtag('config', 'G-XXXXXXXXXX', {
    custom_map: {
      'custom_parameter_1': 'page_type',
      'custom_parameter_2': 'user_type'
    }
  });
  
  // Track custom events
  function trackEvent(eventName, parameters = {}) {
    gtag('event', eventName, {
      event_category: parameters.category || 'engagement',
      event_label: parameters.label || '',
      value: parameters.value || 0,
      ...parameters
    });
  }
  
  // Track page views for SPA-like navigation
  function trackPageView(pageTitle, pagePath) {
    gtag('config', 'G-XXXXXXXXXX', {
      page_title: pageTitle,
      page_location: window.location.origin + pagePath
    });
  }
  
  // Track form submissions
  function trackFormSubmission(formName, formId) {
    gtag('event', 'form_submit', {
      event_category: 'form',
      event_label: formName,
      form_id: formId
    });
  }
  
  // Track file downloads
  function trackDownload(fileName, fileType) {
    gtag('event', 'file_download', {
      event_category: 'download',
      event_label: fileName,
      file_type: fileType
    });
  }
  
  // Track external link clicks
  function trackExternalLink(url, linkText) {
    gtag('event', 'click', {
      event_category: 'external_link',
      event_label: url,
      link_text: linkText
    });
  }
  
  // Track scroll depth
  let scrollDepthTracked = {};
  function trackScrollDepth() {
    const scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
    
    [25, 50, 75, 90].forEach(threshold => {
      if (scrollPercent >= threshold && !scrollDepthTracked[threshold]) {
        scrollDepthTracked[threshold] = true;
        gtag('event', 'scroll', {
          event_category: 'engagement',
          event_label: `${threshold}%`,
          value: threshold
        });
      }
    });
  }
  
  // Track time on page
  let startTime = Date.now();
  function trackTimeOnPage() {
    const timeSpent = Math.round((Date.now() - startTime) / 1000);
    
    // Track significant time milestones
    if (timeSpent === 30 || timeSpent === 60 || timeSpent === 120 || timeSpent === 300) {
      gtag('event', 'timing_complete', {
        event_category: 'engagement',
        event_label: 'time_on_page',
        value: timeSpent
      });
    }
  }
  
  // Auto-track scroll depth
  let scrollTimeout;
  window.addEventListener('scroll', function() {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(trackScrollDepth, 100);
  });
  
  // Auto-track time on page
  setInterval(trackTimeOnPage, 30000); // Check every 30 seconds
  
  // Track when user leaves page
  window.addEventListener('beforeunload', function() {
    const timeSpent = Math.round((Date.now() - startTime) / 1000);
    gtag('event', 'page_exit', {
      event_category: 'engagement',
      event_label: 'time_on_page',
      value: timeSpent
    });
  });
  
  // Track blog post reading progress
  if (window.location.search.includes('page=blog-post')) {
    let readingProgress = 0;
    window.addEventListener('scroll', function() {
      const article = document.querySelector('article');
      if (article) {
        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const scrollTop = window.pageYOffset;
        const windowHeight = window.innerHeight;
        
        const progress = Math.min(100, Math.max(0, 
          ((scrollTop + windowHeight - articleTop) / articleHeight) * 100
        ));
        
        // Track reading milestones
        [25, 50, 75, 100].forEach(milestone => {
          if (progress >= milestone && readingProgress < milestone) {
            readingProgress = milestone;
            gtag('event', 'reading_progress', {
              event_category: 'blog',
              event_label: `${milestone}%`,
              value: milestone
            });
          }
        });
      }
    });
  }
  
  // Make tracking functions globally available
  window.gtag = gtag;
  window.trackEvent = trackEvent;
  window.trackPageView = trackPageView;
  window.trackFormSubmission = trackFormSubmission;
  window.trackDownload = trackDownload;
  window.trackExternalLink = trackExternalLink;
</script>

<!-- Google Tag Manager (optional, for more advanced tracking) -->
<script>
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXXXXX');
</script>

<!-- Facebook Pixel (optional) -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', 'YOUR_PIXEL_ID');
fbq('track', 'PageView');
</script>