export enum AssociationsRequestStatus {
	pending = 1, //state before a final decision is made
	in_progress = 2, //currently being worked on
	cancelled = 3, //cancelled before completion
	on_hold = 4, //temporarily suspended or delayed
	completed = 5, //action successfully finished ???
	archived = 6, //archived for historical purposes
	draft = 7, //has not been finalized or published yet
	accepted = 8, 
	rejected = 9,
}