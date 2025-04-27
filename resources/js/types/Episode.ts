import { Team } from './Team';

export interface Episode {
    id: number;
    title_org: string;
    title_ru: string;
    title_en: string;
    release_date: string;
    teams: Team[];
}
