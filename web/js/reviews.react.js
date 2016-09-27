var ReviewSection = React.createClass({
    getInitialState: function() {
        return {
            reviews: []
        }
    },

    componentDidMount: function() {
        this.loadReviewFromServer();
        setInterval(this.loadReviewFromServer, 2000);
    },

    loadReviewFromServer: function() {
        $.ajax({
            url: this.props.url,
            success: function (data) {
                this.setState({reviews: data.reviews});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <div className="notes-container">
                    <h2 className="notes-header">Reviews</h2>
                    <div><i className="fa fa-plus plus-btn"></i></div>
                </div>
                <ReviewList reviews={this.state.reviews} />
            </div>
        );
    }
});

var ReviewList = React.createClass({
    render: function() {
        var reviewNodes = this.props.reviews.map(function(review) {
            return (
                <ReviewBox user={review.user} rating={review.rating}>{review.comment}</ReviewBox>
            );
        });

        return (
            <div class="single_review">
                {reviewNodes}
            </div>
        );
    }
});

var ReviewBox = React.createClass({
    render: function() {
        return (
            <div class="review_thumb" style="">
            </div>               
            <div className="bubble text-center">
               {this.props.comment}
               <div className="userdetails">
                <h2><a href="#">{this.props.username}</a></h2>
                <p>{this.props.rating}</p>
            </div>
            
        );
    }
});

window.ReviewSection = ReviewSection;
