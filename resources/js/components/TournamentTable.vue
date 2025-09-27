<template>
    <div class="bracket-wrapper" ref="wrapper">
        <!-- HEADER -->
        <div class="bracket-header">
            <div v-for="r in rounds" :key="'h-' + r" class="bracket-header-cell">
                Раунд {{ r }}
            </div>
        </div>

        <!-- SVG LINES -->
        <svg class="bracket-lines" ref="svgOverlay"></svg>

        <!-- BODY -->
        <div class="bracket-row">
            <div v-for="r in rounds" :key="'round-' + r" class="bracket-column">
                <div
                    v-for="(m, i) in (localGroups[`Раунд ${r}`] || [])"
                    :key="'match-' + r + '-' + i"
                    class="match-container"
                    :ref="el => registerMatch(r, i, el)"
                >
                    <div
                        class="participant"
                        :class="{
                            disabled: isDisabled(m, 'p1'),
                            winner: isWinner(m, 'p1')
                        }"
                        @click="askWinner(r, i, 'p1')"
                    >
                        <div class="name">{{ getDisplayName(m.p1) }}</div>
                        <div class="coach">{{ getCoach(m.p1) }}</div>
                    </div>
                    <div
                        class="participant"
                        :class="{
                            disabled: isDisabled(m, 'p2'),
                            winner: isWinner(m, 'p2')
                        }"
                        @click="askWinner(r, i, 'p2')"
                    >
                        <div class="name">{{ getDisplayName(m.p2) }}</div>
                        <div class="coach">{{ getCoach(m.p2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TournamentBracket',
    props: {
        tournamentId: { type: [String, Number], required: true },
        groups: { type: Object, required: true },
        participantsArr: { type: Array, required: true },
        ageCategory: { type: String, required: true },
        weightClass: { type: String, required: true },
    },
    data() {
        return {
            matchRefs: {},
            localGroups: JSON.parse(JSON.stringify(this.groups)),
        };
    },
    computed: {
        rounds() {
            return Object.keys(this.localGroups || {})
                .filter(k => k.startsWith('Раунд '))
                .map(k => +k.split(' ')[1])
                .sort((a, b) => a - b);
        },
        participantsMap() {
            return this.participantsArr.reduce((m, p) => {
                m[p.id] = p;
                return m;
            }, {});
        },
    },
    watch: {
        groups: {
            deep: true,
            immediate: true,
            handler(val) {
                this.localGroups = JSON.parse(JSON.stringify(val));
                this.$nextTick(this.drawLines);
            }
        }
    },
    methods: {
        getDisplayName(id) {
            if (!id) return '—';
            const p = this.participantsMap[id];
            if (!p) return '—';
            return id.toString().startsWith('fake_') ? p.surname : `${p.surname} ${p.name}`;
        },
        getCoach(id) {
            if (!id) return '—';
            const p = this.participantsMap[id];
            if (!p) return '—';
            return id.toString().startsWith('fake_') ? '—' : p.coach;
        },
        isDisabled(match, side) {
            if (!match.p1 || !match.p2) return true;
            if (!match[side] || match[side].toString().startsWith('fake_')) return true;
            if (match.winner !== null) return true;
            return false;
        },
        isWinner(match, side) {
            return match[side] && match.winner === match[side];
        },
        registerMatch(round, idx, el) {
            if (!this.matchRefs[round]) this.matchRefs[round] = {};
            if (el) this.matchRefs[round][idx] = el;
        },
        askWinner(round, idx, sideKey) {
            const match = this.localGroups[`Раунд ${round}`][idx];
            if (this.isDisabled(match, sideKey)) return;
            if (!confirm(`Подтвердить победителя:\n\n${this.getDisplayName(match[sideKey])}`)) return;
            this.confirmWinner(round, idx, sideKey);
        },
        async confirmWinner(round, idx, sideKey) {
            const m = this.localGroups[`Раунд ${round}`][idx];
            m.winner = m[sideKey];

            const next = this.localGroups[`Раунд ${round + 1}`];
            if (next) {
                const tgt = next[Math.floor(idx / 2)];
                if (!tgt.p1) tgt.p1 = m.winner;
                else tgt.p2 = m.winner;
            }

            try {
                const response = await axios.patch(`/tournaments/${this.tournamentId}`, {
                    ageCategory: this.ageCategory,
                    weightClass: this.weightClass,
                    grid: this.localGroups,
                });

                const updated = response.data.grid;
                this.localGroups = JSON.parse(JSON.stringify(updated[this.ageCategory][this.weightClass]));
                this.$nextTick(this.drawLines);

            } catch (e) {
                console.error('Ошибка при сохранении:', e);
            }
        },
        drawLines() {
            const svg = this.$refs.svgOverlay;
            while (svg.firstChild) svg.removeChild(svg.firstChild);
            const wrap = this.$refs.wrapper.getBoundingClientRect();
            svg.setAttribute('width', wrap.width);
            svg.setAttribute('height', wrap.height);

            const draw = (x1, y1, x2, y2) => {
                const l = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                l.setAttribute('x1', x1); l.setAttribute('y1', y1);
                l.setAttribute('x2', x2); l.setAttribute('y2', y2);
                l.setAttribute('stroke', '#777'); l.setAttribute('stroke-width', '2');
                svg.appendChild(l);
            };

            for (let r = 1; r < this.rounds.length; r++) {
                const cur = this.localGroups[`Раунд ${r}`] || [];
                const nxt = this.localGroups[`Раунд ${r + 1}`] || [];
                cur.forEach((_, i) => {
                    const A = this.matchRefs[r]?.[i]?.getBoundingClientRect();
                    const B = this.matchRefs[r + 1]?.[Math.floor(i / 2)]?.getBoundingClientRect();
                    if (!A || !B) return;
                    draw(
                        A.right - wrap.left,
                        A.top + A.height / 2 - wrap.top,
                        B.left - wrap.left,
                        B.top + B.height / 2 - wrap.top
                    );
                });
            }
        }
    },
    mounted() {
        this.$nextTick(this.drawLines);
        window.addEventListener('resize', this.drawLines);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.drawLines);
    }
};
</script>

<style scoped>
.bracket-wrapper {
    position: relative;
    width: 100%;
    min-height: 600px;
    padding: 1rem;
    box-sizing: border-box;
    overflow-x: auto;
}

.bracket-row {
    display: flex;
    align-items: center;
    gap: 40px;
    min-width: max-content;
}

.bracket-column {
    flex: 1 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 30px;
    min-width: 120px;
    height: 100%;
}

.bracket-header {
    display: flex;
    align-items: center;
    gap: 40px;
    margin-bottom: 10px;
}

.bracket-header-cell {
    flex: 1 0 auto;
    min-width: 120px;
    text-align: center;
    font-weight: bold;
}

.bracket-lines {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.match-container {
    width: 100%;
}

.participant .name {
    font-weight: 500;
}

.participant .coach {
    font-size: 12px;
    color: #666;
}

.participant {
    background: #f9f9f9;
    border: 2px solid #777;
    border-radius: 4px;
    padding: 6px 8px;
    text-align: center;
    margin: 2px 0;
    cursor: pointer;
    box-sizing: border-box;
}

.participant:hover {
    background: #eef;
}

.participant.disabled {
    background: #f0f0f0;
    cursor: not-allowed;
    opacity: 0.5;
    border: 2px solid #777;
}

.participant.winner {
    background: #2ecc71 !important;
    color: white;
}

.participant.winner .name {
    font-weight: bold;
}
</style>


