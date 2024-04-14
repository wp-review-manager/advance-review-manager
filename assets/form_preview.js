jQuery(document).ready(function(e){let o={action:"ad_review_manager_ajax",nonce:window.ADRMPublic.adrm_nonce,route:"get_reviews"};const l=e(".review-template_settings_wrapper").attr("data-template-type");e(".adrm-filter-by-star").change(function(n){let a=+e(this).closest(".review-template_settings_wrapper").attr("data-form-id");o.formID=a,o.filter=e(this).val(),u()}),e(".adrm-sort-input").change(function(n){let a=+e(this).closest(".review-template_settings_wrapper").attr("data-form-id");o.formID=a,o.sort=e(this).val(),u()}),e(".adrm-page-number").click(function(n){e(this).addClass("active").siblings().removeClass("active");let a=+e(this).closest(".review-template_settings_wrapper").attr("data-form-id"),i=e(this).text();o.formID=a,o.page=i,u()}),e(".adrm-next-page, .adrm-prev-page").click(function(n){let a=+e(this).closest(".review-template_settings_wrapper").attr("data-form-id"),i=+e(".adrm-page-number.active").text();o.formID=a;let s=e(this).hasClass("adrm-next-page")?i+1:i-1;o.page=s,e(".adrm-page-number.active").removeClass("active"),e(".adrm-page-number").eq(s-1).addClass("active"),u()}),e(".adrm-success-notification").click(function(n){n.preventDefault();let r=e(this).closest("form"),a=+r.attr("data-adrm-form-id");if(f(r)){let d={ratings:[]},t=r.serializeArray(),m=0;r.find("[data-id]").each(function(){t[m].label=e(this).attr("data-id"),m++}),t.map(p=>{p.name.includes("rating")?d.ratings.push({name:p.name,value:p.value,label:p.label}):d[p.name]=p.value});let v={formID:a,formComponent:t,formFieldData:d,action:"ad_review_manager_ajax",nonce:window.ADRMPublic.adrm_nonce,route:"create_review"};c(v,a)}else{var s=e('<div class="adrm-error-notification">Please fill required field !</div>');e(r).append(s),setTimeout(function(){s.remove()},3e3)}});function f(n,r){let a=!0;return n.serializeArray().map(s=>{s.name.includes("rating")?s.value?e(`[name="${s.name}"]`).removeClass("error"):(a=!1,e(`[name="${s.name}"]`).addClass("error")):s.value?e(`[name="${s.name}"]`).removeClass("error"):(a=!1,e(`[name="${s.name}"]`).addClass("error"))}),a}function c(n,r){const a=e(`[data-adrm-form-id="${r}"]`);e.ajax({url:window.ADRMPublic.ajax_url,type:"POST",data:n,success:function(i){e(a).find("input:not([type=submit])").val("");var s=e('<div class="adrm-success-notification">Form submitted successfully</div>');e(a).append(s),setTimeout(function(){s.remove()},3e3),console.log(i)}})}function u(){e.ajax({url:window.ADRMPublic.ajax_url,type:"GET",data:o,success:function(n){if(n.success){const r=e(".adrm_food_review_template_wrapper, .adrm_product_review_temp");g(n.data,r)}}})}function g(n,r){r.empty();let a="",i="",s=0,d=(n==null?void 0:n.reviews)||[];d!=null&&d.length?d.map((t,m)=>{var v;a=t==null?void 0:t.created_at,i=t==null?void 0:t.avatar,s=t==null?void 0:t.average_rating,t=(v=t==null?void 0:t.meta)==null?void 0:v.formFieldData,(l==null?void 0:l.includes("hotel-review-form-template"))||(l==null?void 0:l.includes("food-review-form-template"))?h(r,i,t,a,s):l!=null&&l.includes("product-review-form-template")&&b(r,i,t,a,s)}):r.append('<div class="adrm_food_review_template"><p class="adrm-empty-review">No reviews found yet !</p></div>')}function h(n,r,a,i,s){const d=`
        <div class="adrm_food_review_template">
            <div class="adrm-reviewer-info">
                <div class="adrm-reviewer-avatar">
                    ${r}
                </div>
                <div class="adrm-reviewer-name">
                    <span>${(a==null?void 0:a.name)||""}</span>
                </div>
                <div class="adrm-reviewer-email">
                    <span>${(a==null?void 0:a.email)||""}</span>
                </div>
            </div>
            <div class="adrm-review-body">
                <div class="adrm-review-rating">
                    <div class="adrm-star-rating">
                    ${Array.from({length:5},(t,m)=>`<label name="rating" class="${m<s?"active":""}" value="${m+1}">\u2605</label>`).join("")}
                    </div>
                    <span class="adrm-review-date"> Reviewed ${_(i)}</span>
                </div>
                <div class="adrm-review-content">
                    <p>${a==null?void 0:a.message}</p>
                </div>
                <div class="review-categories">
                        ${a==null?void 0:a.ratings.map(t=>`<div class="adrm-star-rating">
                                ${Array.from({length:5},(m,v)=>`<label name="rating" class="${v<(t==null?void 0:t.value)?"active":""}" value="${v+1}">\u2605</label>`).join("")}

                                <p>${t==null?void 0:t.label}</p>
                            </div>`).join("")}
                </div>
            </div>
        </div>
        `;n.append(d)}function b(n,r,a,i,s){const d=`
            <div class="adrm_review_temp_one adrm_product_review_temp">
                <div class="adrm_review_temp_one_avatar">
                    ${r}
                </div>
                <div class="adrm_review_temp_one_content">
                    <div class="adrm_review_temp_one_content_header">
                        <div class="left">
                            <p class="date adrm-heading">${(a==null?void 0:a.name)||""}</p>
                            <h3 class="adrm_review_temp_one_content_header_name adrm-heading">
                                ${(a==null?void 0:a.title)||""}
                            </h3>
                        </div>
                        <div class="adrm-review-rating">
                            <p> ${_(i)}</p>
                            <div class="adrm-star-rating">
                            ${Array.from({length:5},(t,m)=>`<label name="rating" class="${m<s?"active":""}" value="${m+1}">\u2605</label>`).join("")}
                            </div>
                        </div>
                    </div>
                    <div class="adrm_review_temp_one_content_body">
                        <p class="review">${a==null?void 0:a.message}</p>
                    </div>
                </div>
            </div>`;n.append(d)}function _(n){const r=new Date(n),a=r.getFullYear(),i=String(r.getMonth()+1).padStart(2,"0"),s=String(r.getDate()).padStart(2,"0");return`${a}-${i}-${s}`}});jQuery(document).ready(function(e){e(".btn").click(function(){var o=e(".adrm-testimonial-container.active"),l=o.next(".adrm-testimonial-container"),f=o.prev(".adrm-testimonial-container"),c=e(".progress-dot.active");e(this).attr("id")=="btn-next"?l.length?(o.removeClass("active"),c.removeClass("active"),c.next().addClass("active"),l.addClass("active")):(o.removeClass("active"),c.removeClass("active"),e(".progress-dot").first().addClass("active"),o.siblings().first().addClass("active")):f.length?(o.removeClass("active"),c.removeClass("active"),c.prev().addClass("active"),f.addClass("active")):(o.removeClass("active"),c.removeClass("active"),e(".progress-dot").last().addClass("active"),o.siblings().last().addClass("active"))})});
