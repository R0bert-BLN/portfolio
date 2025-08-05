export interface Tokens {
    accessToken: string
    refreshToken: string
}

export interface Profile {
    first_name: string
    last_name: string
    job_title: string
    description: string
    cv_url: string
    picture_url: string
    github_link: string
    linkedin_link: string
}

export interface Education {
    id: number
    institution_name: string
    specialisation: string
    start_date: string
    end_date: string
    display_order: number
}

export interface CreateEducation {
    institution_name: string
    specialisation: string
    start_date: Date | null
    end_date: Date | null
}

export interface Work {
    id: number
    job_title: string
    job_description: string
    company: string
    start_date: string
    end_date: string
    display_order: number
}

export interface WorkRequest {
    job_title: string
    job_description: string
    company: string
    start_date: string
    end_date: string | null
}
