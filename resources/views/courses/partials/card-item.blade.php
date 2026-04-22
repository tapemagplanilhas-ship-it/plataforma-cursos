<div class="course-card" onclick="window.location='{{ route('courses.show', $course) }}'">
    <div class="course-cover">
        <h2 class="course-cover-title">{{ $course->title }}</h2>
    </div>

    <div class="course-content">
        <div class="course-meta">
            <span class="course-role">{{ ucfirst($course->allowed_role) }}</span>
            <span style="color:#555">{{ $course->created_at->format('d/m/Y') }}</span>
        </div>

        @if($course->description)
            <p class="course-description">
                {{ Str::limit($course->description, 80) }}
            </p>
        @endif

        <div class="course-actions" onclick="event.stopPropagation();">
            <a href="{{ route('courses.show', $course) }}" class="btn-view">👁️ Ver</a>
            
            @if(auth()->user()->isAdmin())
                <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Remover este curso?');" style="flex:1; display:flex;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" style="width:100%;">🗑️</button>
                </form>
            @endif
        </div>
    </div>
</div>