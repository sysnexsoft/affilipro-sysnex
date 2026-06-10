/* ==========================================================================
   AffiliPro — Shared demo data (in Laravel this comes from the DB / controller)
   ========================================================================== */
window.AFFILI = {
  categories: [
    { name: 'Audio', icon: 'headphones', count: 248 },
    { name: 'Laptops', icon: 'laptop', count: 192 },
    { name: 'Smart Home', icon: 'house-signal', count: 173 },
    { name: 'Cameras', icon: 'camera-retro', count: 121 },
    { name: 'Wearables', icon: 'stopwatch', count: 156 },
    { name: 'Gaming', icon: 'gamepad', count: 209 },
    { name: 'Phones', icon: 'mobile-screen', count: 187 },
    { name: 'TVs', icon: 'tv', count: 98 },
    { name: 'Kitchen', icon: 'blender', count: 142 },
    { name: 'Fitness', icon: 'dumbbell', count: 167 },
    { name: 'Office', icon: 'chair', count: 113 },
    { name: 'Accessories', icon: 'plug', count: 231 }
  ],

  products: [
    { id:1, name:'AuraSound Pro 3', cat:'Audio', icon:'headphones-simple', price:149, old:229, rating:4.8, reviews:2840, badge:'pick', tag:'Best Overall', battery:'32h', best:'Noise cancelling' },
    { id:2, name:'UltraView 32" 4K', cat:'TVs', icon:'desktop', price:399, old:649, rating:4.7, reviews:1320, badge:'editor', tag:"Editor's Choice", battery:'—', best:'Creators' },
    { id:3, name:'NovaBook Air 14', cat:'Laptops', icon:'laptop', price:899, old:1099, rating:4.9, reviews:980, badge:'pick', tag:'Top Performance', battery:'18h', best:'Productivity' },
    { id:4, name:'PulseFit Watch S2', cat:'Wearables', icon:'stopwatch', price:179, old:219, rating:4.6, reviews:3410, badge:'deal', tag:'Best Value', battery:'7d', best:'Fitness tracking' },
    { id:5, name:'HomeGuard Cam 360', cat:'Smart Home', icon:'video', price:89, old:129, rating:4.5, reviews:2110, badge:'deal', tag:'Hot Deal', battery:'—', best:'Home security' },
    { id:6, name:'GameForce X Controller', cat:'Gaming', icon:'gamepad', price:69, old:99, rating:4.7, reviews:1540, badge:'pick', tag:'Pro Pick', battery:'40h', best:'Gaming' },
    { id:7, name:'ClearShot Z9 Camera', cat:'Cameras', icon:'camera-retro', price:1199, old:1499, rating:4.8, reviews:760, badge:'editor', tag:"Editor's Choice", battery:'600 shots', best:'Photography' },
    { id:8, name:'BrewMaster Smart Kettle', cat:'Kitchen', icon:'mug-hot', price:59, old:89, rating:4.4, reviews:1890, badge:'deal', tag:'Daily Deal', battery:'—', best:'Kitchen' }
  ],

  testimonials: [
    { name:'Sarah Mitchell', role:'Verified Buyer', text:'Saved me hours of research and $200 on my new laptop. The comparison tables are gold.', avatar:'S' },
    { name:'James Carter', role:'Tech Enthusiast', text:'The most honest reviews online. Pros and cons are always spot on — no fluff.', avatar:'J' },
    { name:'Emily Zhang', role:'Smart Home Fan', text:'I check AffiliPro before every purchase now. Their deals are actually real deals.', avatar:'E' },
    { name:'David Okafor', role:'Gamer', text:'Bought the exact controller they recommended. Best gaming gear advice, period.', avatar:'D' },
    { name:'Lisa Romano', role:'Photographer', text:'Their camera comparison helped me pick the perfect body within budget. Thank you!', avatar:'L' }
  ],

  blog: [
    { title:'Best Wireless Earbuds in 2025 (Tested & Ranked)', cat:'Audio', date:'Jun 4, 2025', read:'8 min', icon:'headphones', author:'Alex Reed' },
    { title:'Laptop Buying Guide: Don\'t Overpay for Specs', cat:'Laptops', date:'Jun 1, 2025', read:'11 min', icon:'laptop', author:'Mia Chen' },
    { title:'7 Smart Home Gadgets Actually Worth It', cat:'Smart Home', date:'May 28, 2025', read:'6 min', icon:'house-signal', author:'Tom Blake' },
    { title:'How We Test: Our 30-Point Scoring System', cat:'Guides', date:'May 25, 2025', read:'5 min', icon:'flask-vial', author:'Editorial Team' },
    { title:'Top 5 Budget 4K Monitors for Creators', cat:'TVs', date:'May 21, 2025', read:'9 min', icon:'desktop', author:'Alex Reed' },
    { title:'Fitness Watches: Are Premium Models Worth It?', cat:'Wearables', date:'May 18, 2025', read:'7 min', icon:'stopwatch', author:'Mia Chen' }
  ],

  faqs: [
    { q:'How does AffiliPro make money?', a:'We earn a small commission when you buy through our links — at no extra cost to you. This never influences our scores or rankings.' },
    { q:'How do you test products?', a:'Every product goes through a standardized 30-point lab and real-world test covering performance, build quality, value and reliability.' },
    { q:'Are your reviews truly independent?', a:'Yes. We buy most products ourselves and our editorial team is completely separate from any affiliate partnerships.' },
    { q:'How often are deals updated?', a:'Prices and coupons are refreshed multiple times per day so you always see the latest verified deals.' },
    { q:'Can I suggest a product to review?', a:'Absolutely — head to our contact page and send us your request. Community suggestions shape our review pipeline.' }
  ],

  brands: ['microchip','meta','apple','android','google','amazon','spotify','steam'],

  trust: [
    { icon:'shield-halved', title:'Independently Tested', text:'30-point lab + real-world testing' },
    { icon:'user-shield', title:'No Pay-to-Rank', text:'Brands cannot buy positions' },
    { icon:'arrows-rotate', title:'Daily Price Checks', text:'Verified, up-to-date deals' },
    { icon:'lock', title:'Secure & Private', text:'Your data is never sold' }
  ]
};
