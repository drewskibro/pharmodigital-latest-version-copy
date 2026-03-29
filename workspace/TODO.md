<instructions>
This file powers chat suggestion chips. Keep it focused and actionable.

Rules:
- Each task must be wrapped in "<todo>" and "</todo>" tags.
- Inside each <todo> block:
  - First line: title (required)
  - Second line: description (optional)
- You should proactively maintain this file after each response, even if the user did not explicitly ask.
- Add tasks only when there are concrete, project-specific next steps from current progress.
- Do NOT add filler tasks. Skip adding if no meaningful next step exists.
- Keep this list high-signal and concise, usually 1-3 strong tasks.
- If there are already 3 strong open tasks, usually do not add more.
- Remove or rewrite stale tasks when they are completed, obsolete, duplicated, or clearly lower-priority than current work.
- Re-rank remaining tasks by current impact and urgency.
- Prefer specific wording tied to real project scope/files; avoid vague goals.
</instructions>

<todo>
Build /services page for "Done For You" pathway
homepage-v2.html links to /services — needs dedicated page with DFY packages, pricing, process
</todo>

<todo>
Build /choose vertical router page
homepage-v2.html "Choose Your Type" card links to /choose — needs pharmacy/clinic/hospital selector
</todo>

<todo>
A/B test homepage-v2 vs original index.html
Compare conversion rates between the two homepage approaches before committing to one
</todo>
