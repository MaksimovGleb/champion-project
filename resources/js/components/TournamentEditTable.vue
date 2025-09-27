<template>
    <div class="tournament-editor">
        <div
            v-for="(match, i) in rounds"
            :key="i"
            class="match-row"
        >
            <div class="participant-column">
                <select
                    v-model="match.p1"
                    @change="swapParticipants(i, 'p1', match.p1)"
                    class="form-select"
                >
                    <option
                        v-for="p in participantsArr"
                        :key="p.id"
                        :value="String(p.id)"
                    >
                        {{ p.surname }} {{ p.name }}
                    </option>
                </select>
                <div class="coach">Тренер: {{ getCoach(match.p1) }}</div>
            </div>

            <div class="vs">VS</div>

            <div class="participant-column">
                <select
                    v-model="match.p2"
                    @change="swapParticipants(i, 'p2', match.p2)"
                    class="form-select"
                >
                    <option
                        v-for="p in participantsArr"
                        :key="p.id"
                        :value="String(p.id)"
                    >
                        {{ p.surname }} {{ p.name }}
                    </option>
                </select>
                <div class="coach">Тренер: {{ getCoach(match.p2) }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        tournamentId: Number,
        ageCategory: String,
        weightClass: String,
        groups: Object,
        participantsArr: Array,
    },
    data() {
        return {
            rounds: JSON.parse(JSON.stringify(this.groups['Раунд 1'])),
        };
    },
    methods: {
        async swapParticipants(matchIndex, side, newId) {
            try {
                const response = await axios.post(
                    `/tournaments/${this.tournamentId}/change`,
                    {
                        ageCategory: this.ageCategory,
                        weightClass: this.weightClass,
                        matchIndex,
                        side,
                        newId,
                    },
                    {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    }
                );

                this.rounds = response.data.weightCategory;
            } catch (error) {
                console.error('Ошибка при обмене:', error);
            }
        },
        getCoach(id) {
            if (!id) return '—';
            const participant = this.participantsArr.find(p => p.id.toString() === id.toString());
            if (!participant) return '—';
            return participant.coach || '—';
        }
    }
};
</script>

<style scoped>
.match-row {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.participant-column {
    display: flex;
    flex-direction: column;
}

.vs {
    display: flex;
    align-items: center;
    font-weight: bold;
    font-size: 1.2rem;
    margin-top: 1.75rem;
}

.form-select {
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
    min-width: 180px;
}

.coach {
    margin-top: 4px;
    font-size: 0.9rem;
    color: #555;
}
</style>
